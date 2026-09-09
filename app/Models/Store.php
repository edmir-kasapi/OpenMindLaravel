<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'operator_id',
        'name',
        'country',
        'address',
        'phone',
        'domain',
        'is_approved'
    ];

    #[Scope]
    protected function country(Builder $query, ?string $country)
    {
        $query->when($country, function($query) use ($country) {
            return $query -> where('country', $country);
        });
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function apiTokens()
    {
        return $this->hasMany(PersonalAccessToken::class);
    }
}
