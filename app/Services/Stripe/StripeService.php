<?php

namespace App\Services\Stripe;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\Product;
use App\Models\ShipmentStatus;
use Laravel\Cashier\Cashier;

class StripeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function processPaymentData(Product $product, array $paymentData)
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
            'order_status' => OrderStatus::PENDING,
            'payment_status' => PaymentStatus::UNPAID,
            'shipment_status' => ShipmentStatus::NOT_SHIPPED
        ]);

        return $order;
    }

    public function processCheckoutConfirmation(string $sessionId): ?Order
    {
        if(!$sessionId)
        {
            return null;
        }

        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

        if($session->payment_status !== 'paid')
        {
            return null;
        }

        $orderId = $session['metadata']['order_id'];

        if(!$orderId)
        {
            return null;
        }

        $order = Order::find($orderId);

        if(!$order)
        {
            return null;
        }

        if($order->payment_status !== PaymentStatus::PAID)
        {
            $order -> update([
                'payment_status' => PaymentStatus::PAID,
                'payment_intent_id' => $session->payment_intent
                ]);

        }

        return $order;
    }

    public function processCheckoutCancellation(string $sessionId): ?Order
    {
        if(!$sessionId)
        {
            return null;
        }

        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
        $orderId = $session['metadata']['order_id'];

        if(!$orderId)
        {
            return null;
        }

        $order = Order::find($orderId);

        if(!$order)
        {
            return null;
        }

        return $order;
    }

    public function processOrderRefund(string $id): ?Order
    {
        if(!$id)
        {
            return null;
        }

        $order = Order::find($id);

        if(!$order)
        {
            return null;
        }

        if(!$order->payment_intent_id)
        {
            return null;
        }

        if($order->isRefundPending())
        {
            Cashier::stripe()->refunds->create([
            'payment_intent' => $order->payment_intent_id
            ]);

            return $order;
        }

        return null;
    }
}
