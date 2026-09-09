<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateApiTokenRequest;
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

        return view('pages.operator.stores.api-keys.api-keys', ['store' => $store]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Store $store)
    {
        return view('pages.operator.stores.api-keys.api-keys-create', ['store' => $store]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $store, CreateApiTokenRequest $request)
    {
        $token = $this->apiKeyService->createToken($store, $request->user(), $request->validated());

        session()->flash('created_api_key', $token->plainTextToken);

       return redirect()->route('operator.stores.api-keys.show', $store);
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        $token =  session('created_api_key');

        if (!$token) {
        return redirect()
            ->route('operator.stores.api-keys', $store->id)
            ->with('error', 'The access token is no longer available.');
    }

        return view('pages.operator.stores.api-keys.api-keys-show-created-key', ['token' => $token, 'store' => $store]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalAccessToken $token)
    {
        $this->apiKeyService->revokeToken($token);

        return response()->json(['status' => 'success', 'message' => 'Token revoked successfully!']);
    }
}
