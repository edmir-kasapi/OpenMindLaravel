<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    protected $fillable = [
        'hashed_name',
        'original_name',
        'extension',
        'size',
        'product_id'
    ];

    public function getSrc()
    {
        return $this->hashed_name;
    }

    public function product()
    {
        return $this -> belongsTo(Product::class);
    }
}
