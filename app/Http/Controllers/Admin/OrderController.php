<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->orderService->getAllOrders($request);
        }

        return view('pages.admin.orders.orders');
    }

    public function trashIndex(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->orderService->getTrashedOrders($request);
        }

        return view('pages.admin.orders.orders-trashed');
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
    public function show(Order $order)
    {
        return view('pages.admin.orders.view-order', ['order' => $order]);
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
    public function destroy(Order $order, Request $request)
    {
        $this->orderService->archiveOrder($order);

        if ($request->boolean('redirect')) {
            session(['success' => "Order cancelled Successfully!"]);
            return response()->json([
                'status' => 'success',
                'message' => route('admin.orders'),
                'redirect' => route('admin.orders')
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Order Archived Successfully!']);
    }

    public function restore(string $id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $this->orderService->restoreOrder($order);

        /*

        if (!$this->orderService->restoreOrder($order)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot restore order! Not enough stock left.'
            ]);
        }

        */

        return response()->json(['status' => 'success', 'message' => 'Order Restored Successfully!']);
    }

    public function forceDelete(string $id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $this->orderService->forceDeleteOrder($order);
        return response()->json(['status' => 'success', 'message' => 'Order Permanently deleted!']);
    }
}
