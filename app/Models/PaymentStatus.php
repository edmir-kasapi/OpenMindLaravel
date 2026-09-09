<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name'
        ];

    public const UNPAID = 1;
    public const PAID = 2;
    public const REFUND_PENDING = 3;
    public const REFUNDED = 4;
    public const PARTIALLY_REFUNDED = 5;
    public const FAILED = 6;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
