<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name'
        ];

    public const PENDING = 1;
    public const CONFIRMED = 2;
    public const CANCELLED = 3;
    public const COMPLETED = 4;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
