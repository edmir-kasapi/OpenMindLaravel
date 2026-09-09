<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\EditStoreRequest;
use App\Models\Store;
use App\Services\Stores\StoreService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(
        protected StoreService $storeService
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->wantsJson())
        {
            return $this->storeService->getAllStores($request);
        }

        return view('pages.admin.stores.stores');
    }

    public function trashIndex(Request $request)
    {
        if($request->wantsJson())
        {
            return $this->storeService->getDisabledStores($request);
        }

        return view('pages.admin.stores.stores-trashed');
    }

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
    public function store(Request $request)
    {
        //
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
    public function edit(Store $store)
    {
        return view('pages.admin.stores.edit-store', ['store' => $store]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Store $store, EditStoreRequest $request)
    {
        $this->storeService->updateStore($store, $request->validated());

        return redirect()->back()->with('success', 'Store updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store, Request $request)
    {
        $this->storeService->disableStore($store);

        if($request->boolean('redirect'))
        {
            session(['success' => 'Store is now disabled.']);
            return response()->json([
                'status' => 'success',
                'message'=>'Store is now disabled.',
                'redirect' => route('admin.stores')
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Store is now disabled.']);
    }

    public function restore(string $id, Request $request)
    {
        $store = Store::onlyTrashed()->findOrFail($id);
        $this->storeService->reinstateStore($store);

        return response()->json(['status' => 'success', 'message' => 'Store successfully reinstated.']);
    }

    public function forceDelete(string  $id, Request $request)
    {
        $store = Store::onlyTrashed()->findOrFail($id);

        $this->storeService->forceDeleteStore($store);

        return response()->json(['status' => 'success', 'message' => 'Store deleted permanently.']);
    }
}
