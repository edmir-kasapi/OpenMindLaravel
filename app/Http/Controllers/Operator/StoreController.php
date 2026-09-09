<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\CreateStoreRequest;
use App\Http\Requests\Operator\DisableStoreRequest;
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
            return $this->storeService->getUserStores(auth()->user(), $request);
        }
        return view('pages.operator.stores.stores');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('pages.operator.stores.create-store');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStoreRequest $request)
    {
        $this->storeService->createStore($request->validated());

        return redirect()->back()->with('success', 'Store registered successfully!');
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
        return view('pages.operator.stores.edit-store', ['store' => $store]);
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
    public function destroy(Store $store, DisableStoreRequest $request)
    {
        $this->storeService->disableStore($store);

        if($request->boolean('redirect'))
        {
            session(['success'=>'Store is now disabled']);
            return response()->json([
                'status' => 'success',
                'message' => 'Store is now disabled.',
                'redirect' => route('operator.stores')
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Store is now disabled.']);
    }
}
