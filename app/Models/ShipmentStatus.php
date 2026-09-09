<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public const NOT_SHIPPED = 1;
    public const PACKED = 2;
    public const SHIPPED = 3;
    public const DELIVERED = 4;
    public const RETURNED = 5;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
