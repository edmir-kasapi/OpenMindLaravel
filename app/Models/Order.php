<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payment_intent_id',
        'user_id',
        'product_id',
        'address',
        'quantity',
        'total_price',
        'order_status',
        'payment_status',
        'shipment_status',
        'delivered_at'
    ];

    const STATUS_COMPLETE = 1;

    public function isRefundPending(): bool
    {
        return $this->payment_status === PaymentStatus::REFUND_PENDING;
    }

    public function isArchived(): bool
    {
        return $this->deleted_at !== null;
    }

    public function isInActionWindow(): bool
    {
        return $this->delivered_at === null
            && $this->delivered_at >= now()->subMonth();
    }

    #[Scope]
    protected function findOrderStatus(Builder $query, ?int $status_id)
    {
        $query->when($status_id, function($query) use ($status_id){
            return $query->where('order_status', $status_id);
        });
    }

    #[Scope]
    protected function findPaymentStatus(Builder $query, ?int $status_id)
    {
        $query->when($status_id, function($query) use ($status_id){
            return $query->where('payment_status', $status_id);
        });
    }

    #[Scope]
    protected function findShipmentStatus(Builder $query, ?int $status_id)
    {
        $query->when($status_id, function($query) use ($status_id){
            return $query->where('shipment_status', $status_id);
        });
    }

    #[Scope]
    protected function today(Builder $query)
    {
        return $query->whereDay('created_at', now()->day)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->get();
    }

    #[Scope]
    protected function thisMonth(Builder $query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->get();
    }

    #[Scope]
    protected function thisYear(Builder $query)
    {
        return $query->whereYear('created_at', now()->year)
                    ->get();
    }

    public function getOrderStatus()
    {
        return $this->orderStatus?->name;
    }

    public function getPaymentStatus()
    {
        return $this->paymentStatus?->name;
    }

    public function getShipmentStatus()
    {
        return $this->shipmentStatus?->name;
    }

    public function canRetry()
    {
        return $this->order_status !== OrderStatus::CANCELLED
            && $this->payment_status ===PaymentStatus::UNPAID;
    }

    public function canCancel(): bool
    {
       return !in_array($this->order_status, [OrderStatus::CANCELLED, OrderStatus::COMPLETED])
           && !in_array($this->shipment_status, [ShipmentStatus::SHIPPED, ShipmentStatus::DELIVERED]);
    }

    public function canConfirm(): bool
    {
        return $this->order_status === OrderStatus::PENDING
            && $this->payment_status === PaymentStatus::PAID;
    }

    public function canUnconfirm(): bool
    {
        return $this->order_status === OrderStatus::CONFIRMED
            && $this->payment_status === PaymentStatus::PAID
            && $this->shipment_status === ShipmentStatus::NOT_SHIPPED;
    }

    public function canPack(): bool
    {
        return $this->order_status === OrderStatus::CONFIRMED
            && $this->shipment_status === ShipmentStatus::NOT_SHIPPED;
    }

    function canShip(): bool
    {
        return $this->order_status === OrderStatus::CONFIRMED
            && $this->payment_status === PaymentStatus::PAID
            && $this->shipment_status === ShipmentStatus::PACKED;
    }

    public function canDeliver(): bool
    {
        return $this->shipment_status === ShipmentStatus::SHIPPED;
    }

    public function canReturn(): bool
    {
        return in_array($this->shipment_status, [ShipmentStatus::SHIPPED, ShipmentStatus::DELIVERED])
            && $this->payment_status === PaymentStatus::PAID
            && $this->isInActionWindow()
            && !$this->isArchived();
    }

    function canRefund(): bool
    {
        return $this->payment_status === PaymentStatus::PAID
            && $this->shipment_status !== ShipmentStatus::SHIPPED
            && $this->isInActionWindow()
            && !$this->isArchived();
    }

    public function canArchive(): bool
    {
        return in_array($this->order_status, [OrderStatus::CANCELLED, OrderStatus::COMPLETED])
            && !$this->isRefundPending()
            && !$this->isArchived();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status');
    }

    public function shipmentStatus()
    {
        return $this->belongsTo(ShipmentStatus::class, 'shipment_status');
    }
}
