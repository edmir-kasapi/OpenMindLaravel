<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type_id',
        'price',
        'stock',
        'reserved_stock',
        'available_stock',
        'brand'
    ];

    #[Scope]
    protected function searchName(Builder $query, ?string $name)
    {
        $query->when($name, function($query) use ($name) {
            return $query -> where('name', 'LIKE', "%".$name."%");
        });
    }

    #[Scope]
    protected function searchBrand(Builder $query, ?string $brand)
    {
        $query->when($brand, function($query) use ($brand) {
            return $query -> where('brand', 'LIKE', "%".$brand."%");
        });
    }

    #[Scope]
    protected function category(Builder $query, ?int $type_id)
    {
        $query->when($type_id, function($query) use ($type_id) {
            return $query-> where('type_id', $type_id);
        });
    }

    #[Scope]
    protected function outOfStock(Builder $query): Builder
    {
        return $query -> where('available_stock', '<=', 0);
    }

    #[Scope]
    protected function lowStock(Builder $query): Builder
    {
        return $query -> whereBetween('available_stock', [1, 10]);
    }

    #[Scope]
    protected function mediumStock(Builder $query): Builder
    {
        return $query -> whereBetween('available_stock', [11, 50]);
    }

    #[Scope]
    protected function inStock(Builder $query): Builder
    {
        return $query -> where('available_stock', '>', 50);
    }

    #[Scope]
    protected function minPrice(Builder $query, ?float $price)
    {
        $query->when($price, function ($query) use ($price) {
            return $query -> where('price','>=', $price);
        });

    }

    #[Scope]
    protected function maxPrice(Builder $query, ?float $price)
    {
        $query->when($price, function ($query) use ($price) {
            return $query -> where('price','<=', $price);
        });
    }

    #[Scope]
    protected function filterStock(Builder $query, ?string $stock_level): void
    {
        match ($stock_level)
        {
            'in-stock'      => $query->inStock(),
            'medium-stock'  => $query->mediumStock(),
            'low-stock'     => $query->lowStock(),
            'out-of-stock'  => $query->outOfStock(),
            default         => null
        };
    }

    #[Scope]
    protected function sortBy(Builder $query, ?string $sort_type)
    {
        match ($sort_type)
        {
            'name-asc'  => $query -> orderBy('name') -> orderBy('id'),
            'name-desc' => $query -> orderByDesc('name') -> orderByDesc('id'),
            'price-asc' => $query -> orderBy('price') -> orderBy('id'),
            'price-desc'=> $query -> orderByDesc('price') -> orderByDesc('id'),
            'stock-asc' => $query -> orderBy('stock') -> orderBy('id'),
            'stock-desc'=> $query -> orderByDesc('stock',) -> orderByDesc('id'),
            'date-asc'  => $query -> oldest('created_at') -> orderBy('id'),
            'date-desc' => $query -> latest('created_at') -> orderByDesc('id'),
            default     => $query -> latest('created_at') -> orderByDesc('id')
        };
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

    public function reserveStock(int $quantity): void
    {
        $this->where('id', $this->id)->incrementEach([
            'reserved_stock' => $quantity,
            'available_stock' => ($quantity*-1)
        ],
        []
        );
    }

    public function cancelStockReservation(int $quantity): void
    {
        $this->where('id', $this->id)->incrementEach([
            'reserved_stock' => ($quantity*-1),
            'available_stock' => $quantity
        ],
        []
        );
    }

    public function confirmStockReservation(int $quantity)
    {
        $this->where('id', $this->id)->incrementEach([
            'stock' => ($quantity*-1),
            'reserved_stock' => ($quantity*-1)
        ],
        []
        );
    }

    public function undoStockConfirmation(int $quantity)
    {
        $this->where('id', $this->id)->incrementEach([
            'stock' => $quantity,
            'reserved_stock' => $quantity
        ],
        []
        );
    }

    public function returnStock(int $quantity)
    {
        $this->where('id', $this->id)->incrementEach([
            'stock' => $quantity,
            'available_stock' => $quantity
        ],
        []
        );
    }

    public function type()
    {
        return $this -> belongsTo(ProductType::class);
    }

    public function pictures()
    {
        return $this -> hasMany(ProductPhoto::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
