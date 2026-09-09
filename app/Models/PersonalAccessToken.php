<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    public static function findToken($token): ?static
    {
        $accessToken = parent::findToken($token);

        if (!$accessToken || !$accessToken->isValid()) {
            return null;
        }

        return $accessToken;
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function isValid(): bool
    {
        return $this->revoked_at === null
            && ($this->expires_at === null || $this->expires_at->isFuture())
            && $this->store?->is_approved;
    }

    #[Scope]
    protected function unrevoked(Builder $query)
    {
        return $query->whereNull('revoked_at');
    }

    #[Scope]
    protected function revoked(Builder $query)
    {
        return $query->whereNotNull('revoked_at');
    }

    public function canReadProduct()
    {
        return in_array('products:read', $this->abilities);
    }

    public function canReadCollections()
    {
        return in_array('collections:read', $this->abilities);
    }

    public function revoke()
    {
        $this->revoked_at = Carbon::now();
        $this->save();
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
