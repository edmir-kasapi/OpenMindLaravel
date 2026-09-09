<?php

namespace App\Services\API;

use App\Models\PersonalAccessToken;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class APIKeyService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getStoreKeys(Store $store, Request $request)
    {
        $keys = PersonalAccessToken::query()
            ->where('store_id', $store->id)
            ->unrevoked();
        return DataTables::eloquent($keys)
            //->addIndexcolumn()
            ->addColumn('created_at', function ($key) {
                return Carbon::parse($key->created_at)->format('d-m-Y');
            })
            ->addColumn('can_read_product', function ($key) {
                return view('components.datatable.badges.ability-badge', ['ability' => $key->canReadProduct()]);
            })
            ->addColumn('can_read_collections', function ($key) {
                return view('components.datatable.badges.ability-badge', ['ability' => $key->canReadCollections()]);
            })
            ->addColumn('last_used_at', function ($key) {
                if (!$key->last_used_at) {
                    return 'Not Used Yet';
                }

                return Carbon::parse($key->last_used_at)->format('d-m-Y');
            })
            ->addColumn('expires_at', function ($key) {
                if (!$key->expires_at) {
                    return 'Never';
                }

                return Carbon::parse($key->expires_at)->format('d-m-Y');
            })
            ->addColumn('action', function ($key) {
                return view('components.datatable.buttons.groups.api-keys-operator-button-group', ['id' => $key->id]);
            })
            ->make(true);
    }

    public function getStoreRevokedKeys(Store $store, Request $request)
    {
        $keys = PersonalAccessToken::query()
            ->where('store_id', $store->id)
            ->revoked();
        return DataTables::eloquent($keys)
            //->addIndexcolumn()
            ->addColumn('revoked_at', function ($key) {
                return Carbon::parse($key->revoked_at)->format('d-m-Y');
            })
            ->addColumn('can_read_product', function ($key) {
                return view('components.datatable.badges.ability-badge', ['ability' => $key->canReadProduct()]);
            })
            ->addColumn('can_read_collections', function ($key) {
                return view('components.datatable.badges.ability-badge', ['ability' => $key->canReadCollections()]);
            })
            ->addColumn('last_used_at', function ($key) {
                if (!$key->last_used_at) {
                    return 'Not Used Yet';
                }

                return Carbon::parse($key->last_used_at)->format('d-m-Y');
            })
            ->addColumn('expires_at', function ($key) {
                if (!$key->expires_at) {
                    return 'Never';
                }

                return Carbon::parse($key->expires_at)->format('d-m-Y');
            })
            ->addColumn('action', function ($key) {
                return view('components.datatable.buttons.groups.api-keys-revoked-admin-button-group', ['id' => $key->id]);
            })
            ->make(true);
    }

    public function createToken(Store $store, User $user, array $tokenData)
    {
        $expiresAt = $tokenData['duration'] === 'never' ? null : now()->addDays((int) $tokenData['duration']);

        $token = $user->createToken(
            $tokenData['name'],
            $tokenData['abilities'],
            $expiresAt
        );

        $accessToken = $token->accessToken;

        $accessToken->store_id = $store->id;
        $accessToken->save();

        return $token;
    }

    public function revokeToken(PersonalAccessToken $token)
    {
        $token->revoke();
    }

    public function deleteToken(PersonalAccessToken $token)
    {
        $token->delete();
    }
}
