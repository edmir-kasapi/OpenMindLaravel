<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateApiTokenRequest;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $store, CreateApiTokenRequest $request)
    {

        $validated = $request->validated();

        $expiresAt = $validated['duration'] === 'never' ? null : now()->addDays((int) $request->duration);

        $token = $request->user()->createToken(
            $validated['name'],
            $validated['abilities'],
            $expiresAt
        );

        $accessToken = $token->accessToken;

        $accessToken->store_id = $store->id;
        $accessToken->save();

        return response()->json([
            'message' => 'API key created successfully.',
            'api_key' => $token->plainTextToken,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
