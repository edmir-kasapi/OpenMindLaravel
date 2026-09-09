<?php

namespace App\Services\Stores;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class StoreService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createStore(array $storeData)
    {
        Store::create([
            'operator_id' => auth()->user()->id,
            'name' => $storeData['name'],
            'country' => $storeData['country'],
            'address' => $storeData['address'],
            'phone' => $storeData['phone'],
            'domain' => $storeData['domain'],
        ]);
    }

    public function getUserStores(User $user, Request $request)
    {
        $stores = Store::query()
            ->where('operator_id', $user->id)
            ->country($request->country);
        return DataTables::eloquent($stores)
            //->addIndexcolumn()
            ->addColumn('created_at', function ($store) {
               return Carbon::parse($store->created_at)->format('d-m-Y');
           })
           ->addColumn('status', function ($store) {
                return view('components.datatable.badges.approval-status-badge', ['isApproved' => $store->is_approved]);
           })
            ->addColumn('action', function ($store) {
                return view('components.datatable.buttons.groups.active-stores-operator-button-group', ['store' => $store]);
           })
            ->make(true);
    }

    public function getAllStores(Request $request)
    {
        $stores = Store::query()
            ->country($request->country);
        return DataTables::eloquent($stores)
            //->addIndexcolumn()
            ->addColumn('operator', function ($store) {
                $operator = $store->operator;

                return view('components.datatable.user-table-cell', ['user' => $operator]);
           })
            ->addColumn('created_at', function ($store) {
               return Carbon::parse($store->created_at)->format('d-m-Y');
           })
           ->addColumn('status', function ($store) {
                return view('components.datatable.badges.approval-status-badge', ['isApproved' => $store->is_approved]);
           })
            ->addColumn('action', function ($store) {
                return view('components.datatable.buttons.groups.active-stores-admin-button-group', ['store' => $store]);
           })
            ->make(true);
    }

    public function getDisabledStores(Request $request)
    {
        $stores = Store::onlyTrashed()
            ->country($request->country);
        return DataTables::eloquent($stores)
            //->addIndexcolumn()
            ->addColumn('operator', function ($store) {
                $operator = $store->operator;

                return view('components.datatable.user-table-cell', ['user' => $operator]);
           })
            ->addColumn('deleted_at', function ($store) {
               return Carbon::parse($store->deleted_at)->format('d-m-Y');
           })
           ->addColumn('status', function ($store) {
                return view('components.datatable.badges.approval-status-badge', ['isApproved' => $store->is_approved]);
           })
            ->addColumn('action', function ($store) {
                return view('components.datatable.buttons.groups.disabled-stores-admin-button-group', ['id' => $store->id]);
           })
            ->make(true);
    }

    public function updateStore(Store $store, array $storeData)
    {
        $store->update($storeData);
    }

    public function disableStore(Store $store)
    {
        $store->delete();
    }

    public function reinstateStore(Store $store)
    {
        $store->restore();
    }

    public function forceDeleteStore(Store $store)
    {
        $store->forceDelete();
    }

    public function approveStore(Store $store)
    {
        if(!$store->is_approved)
        {
            $store->update([
                'is_approved' => true
            ]);
        }
    }

    public function disapproveStore(Store $store)
    {
        if($store->is_approved)
        {
            $store->update([
                'is_approved' => false
            ]);
        }
    }
}
