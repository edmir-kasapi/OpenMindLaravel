<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\Product;
use App\Models\ShipmentStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createOrder(Product $product, array $paymentData)
    {
        $quantity = $paymentData['quantity'];
        $address = $paymentData['address'];

        $totalPrice =  $quantity * $product->price;

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'product_id' => $product->id,
            'address' => $address,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'order_status' => 1,
            'payment_status' => 1,
            'shipment_status' => 1
        ]);

        $product->reserveStock($quantity);

        return $order;
    }

    public function getAllOrders(Request $request)
    {
        $orders = Order::query()
            ->findOrderStatus($request->order_status_id)
            ->findPaymentStatus($request->payment_status_id)
            ->findShipmentStatus($request->shipment_status_id);
        return DataTables::eloquent($orders)
            //->addIndexcolumn()
            ->addColumn('user', function ($order) {
                $user = $order->user;

                return view('components.datatable.user-table-cell', ['user' => $user]);
            })
            ->addColumn('product', function ($order) {

                if ($order->product) {
                    return $order->product->name;
                }

                return 'Product Deleted';
            })
            ->addColumn('order_status', function ($order) {
                return view('components.datatable.badges.order-status-badge', ['status' => $order->getOrderStatus()]);
            })
            ->addColumn('payment_status', function ($order) {
                return view('components.datatable.badges.payment-status-badge', ['status' => $order->getPaymentStatus()]);
            })
            ->addColumn('shipment_status', function ($order) {
                return view('components.datatable.badges.shipment-status-badge', ['status' => $order->getShipmentStatus()]);
            })
            ->addColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->format('d-m-Y');
            })
            ->addColumn('action', function ($order) {
                return view('components.datatable.buttons.groups.admin-active-orders-action-button-group', ['order' => $order]);
            })
            ->make(true);
    }

    public function getTrashedOrders(Request $request)
    {
        $orders = Order::onlyTrashed()
            ->findOrderStatus($request->status_id)
            ->findPaymentStatus($request->payment_status_id)
            ->findShipmentStatus($request->shipment_status_id);;
        return DataTables::eloquent($orders)
            //->addIndexcolumn()
            ->addColumn('user', function ($order) {
                $user = $order->user;

                return view('components.datatable.user-table-cell', ['user' => $user]);
            })
            ->addColumn('product', function ($order) {

                if ($order->product) {
                    return $order->product->name;
                }

                return 'Product Deleted';
            })
            ->addColumn('order_status', function ($order) {
                return view('components.datatable.badges.order-status-badge', ['status' => $order->getOrderStatus()]);
            })
            ->addColumn('payment_status', function ($order) {
                return view('components.datatable.badges.payment-status-badge', ['status' => $order->getPaymentStatus()]);
            })
            ->addColumn('shipment_status', function ($order) {
                return view('components.datatable.badges.shipment-status-badge', ['status' => $order->getShipmentStatus()]);
            })
            ->addColumn('deleted_at', function ($order) {
                return Carbon::parse($order->deleted_at)->format('d-m-Y');
            })
            ->addColumn('action', function ($order) {
                return view('components.datatable.buttons.groups.cancelled-orders-button-group', ['id' => $order->id, 'status' => $order->getOrderStatus()]);
            })
            ->make(true);
    }

    public function getUserOrders(User $user, Request $request)
    {
        $orders = Order::query()
            ->where('user_id', $user->id)
            ->findOrderStatus($request->status_id)
            ->findPaymentStatus($request->payment_status_id)
            ->findShipmentStatus($request->shipment_status_id);
        return DataTables::eloquent($orders)
            //->addIndexcolumn()
            ->addColumn('product', function ($order) {

                if ($order->product) {
                    return $order->product->name;
                }

                return 'Product Deleted';
            })
            ->addColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->format('d-m-Y');
            })
            ->addColumn('order_status', function ($order) {
                return view('components.datatable.badges.order-status-badge', ['status' => $order->getOrderStatus()]);
            })
            ->addColumn('payment_status', function ($order) {
                return view('components.datatable.badges.payment-status-badge', ['status' => $order->getPaymentStatus()]);
            })
            ->addColumn('shipment_status', function ($order) {
                return view('components.datatable.badges.shipment-status-badge', ['status' => $order->getShipmentStatus()]);
            })
            ->addColumn('action', function ($order) {
                return view('components.datatable.buttons.groups.user-orders-action-button-group', ['order' => $order]);
            })
            ->make(true);
    }

    public function markOrderAsConfirmed(Order $order): bool
    {
        if ($order->canConfirm()) {
            $order->product->confirmStockReservation($order->quantity);
            $order->update([
                'order_status' => OrderStatus::CONFIRMED
            ]);

            return true;
        }

        return false;
    }

    public function unmarkConfimedOrder(Order $order): bool
    {
        if ($order->canUnconfirm()) {
            $order->product->undoStockConfirmation($order->quantity);
            $order->update([
                'order_status' => OrderStatus::PENDING
            ]);

            return true;
        }

        return false;
    }

    public function markOrderAsPacked(Order $order): bool
    {
        if ($order->canPack()) {
            $order->update([
                'shipment_status' => ShipmentStatus::PACKED
            ]);

            return true;
        }

        return false;
    }

    public function unmarkPackedOrder(Order $order): bool
    {
        if ($order->canShip()) {
            $order->update([
                'shipment_status' => ShipmentStatus::NOT_SHIPPED
            ]);

            return true;
        }

        return false;
    }

    public function markOrderAsShipped(Order $order): bool
    {
        if ($order->canShip()) {
            $order->update([
                'shipment_status' => ShipmentStatus::SHIPPED
            ]);

            return true;
        }

        return false;
    }

    public function unmarkShippedOrder(Order $order): bool
    {
        if ($order->canDeliver()) {
            $order->update([
                'shipment_status' => ShipmentStatus::PACKED
            ]);

            return true;
        }

        return false;
    }

    public function markOrderAsDelivered(Order $order): bool
    {
        if ($order->canDeliver()) {
            $order->update([
                'order_status' => OrderStatus::COMPLETED,
                'shipment_status' => ShipmentStatus::DELIVERED,
                'delivered_at' => now()
            ]);

            return true;
        }

        return false;
    }

    public function unmarkDeliveredOrder(Order $order): bool
    {
        if ($order->canReturn()) {
            $order->update([
                'order_status' => OrderStatus::CONFIRMED,
                'shipment_status' => ShipmentStatus::SHIPPED,
                'delivered_at' => null
            ]);


            return true;
        }

        return false;
    }

    public function cancelOrder(Order $order): bool
    {
        if (!$order->canCancel()) {
            return false;
        }

        switch ($order->order_status) {
            case OrderStatus::CONFIRMED:
                $order->product->returnStock($order->quantity);
                break;

            case OrderStatus::PENDING:
                $order->product->cancelStockReservation($order->quantity);
                break;
        }

        $new_order_status = OrderStatus::CANCELLED;
        $new_payment_status = ($order->payment_status === PaymentStatus::PAID) ? PaymentStatus::REFUND_PENDING : PaymentStatus::UNPAID;
        $new_shipment_status = ShipmentStatus::NOT_SHIPPED;

        $order->update([
            'order_status' => $new_order_status,
            'payment_status' => $new_payment_status,
            'shipment_status' => $new_shipment_status
        ]);

        return true;
    }

    public function markForRefund(Order $order)
    {
        $order->update([
            'payment_status' => PaymentStatus::REFUND_PENDING
        ]);
    }

    public function markOrderAsRefunded(Order $order): bool
    {
        if ($order->isRefundPending()) {
            $order->update([
                'payment_status' => PaymentStatus::REFUNDED,
            ]);

            return true;
        }

        return false;
    }

    public function unmarkRefund(string $id): bool
    {
        $order = Order::find($id);

        if (!$order) {
            return false;
        }

        if ($order->isRefundPending()) {
            $order->update([
                'payment_status' => PaymentStatus::PAID,
            ]);

            return true;
        }

        return false;
    }

    public function returnOrder(string $id): bool
    {
        if(!$id)
        {
            return false;
        }

        $order = Order::find($id);

        if(!$order)
        {
            return false;
        }

        if(!$order->canReturn())
        {
            return false;
        }

        $order->product->returnStock($order->amount);

        $new_order_status = ($order->shipment_status === ShipmentStatus::SHIPPED) ? OrderStatus::CANCELLED : $order->order_status;
        $new_payment_status = PaymentStatus::REFUND_PENDING;
        $new_shipment_status = ShipmentStatus::RETURNED;

        $order->update([
                'order_status' => $new_order_status,
                'payment_status' => $new_payment_status,
                'shipment_status' => $new_shipment_status
            ]);

        return true;
    }

    public function restoreOrder(Order $order)
    {
        $order->restore();
    }

    public function archiveOrder(Order $order)
    {
        $order->delete();
    }

    public function forceDeleteOrder(Order $order)
    {
        $order->forceDelete();
    }
}
