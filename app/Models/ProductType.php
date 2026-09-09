<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'type'
    ];

    public function getTypeName()
    {
        return $this -> type;
    }

    public function products()
    {
        return $this -> hasMany(Product::class, 'type_id');
    }
}

