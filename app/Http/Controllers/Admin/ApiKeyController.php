<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalAccessToken;
use App\Models\Store;
use App\Services\API\APIKeyService;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function __construct(
        protected APIKeyService $apiKeyService
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Store $store, Request $request)
    {
        if($request->wantsJson())
        {
            return $this->apiKeyService->getStoreKeys($store, $request);
        }

        return view('pages.admin.stores.api-keys.api-keys', ['store' => $store]);
    }

    public function revokedIndex(Store $store, Request $request)
    {
        if($request->wantsJson())
        {
            return $this->apiKeyService->getStoreRevokedKeys($store, $request);
        }

        return view('pages.admin.stores.api-keys.api-keys-revoked', ['store' => $store]);
    }

    public function revoke(PersonalAccessToken $token, Request $request)
    {
        $this->apiKeyService->revokeToken($token);

        return response()->json(['status' => 'success', 'message' => 'Token revoked successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalAccessToken $token)
    {
        $this->apiKeyService->deleteToken($token);

        return response()->json(['status' => 'success', 'message' => 'Token deleted successfuly']);
    }
}
