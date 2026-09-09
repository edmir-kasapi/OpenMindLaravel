<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
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
            return $this->orderService->getUserOrders(auth()->user(), $request);
        }

        return view('pages.user.orders.main-menu-orders');
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
    /**
    Dont forget to delete this
    */
    public function store(Request $request)

    {
        $product = Product::findOrFail($request->product_id);

        $validated = $request->validate([
            'address' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1', "max:$product->stock"]
        ]);

        $totalPrice = $validated['quantity'] * $product->price;

        Order::create([
            'user_id' => auth()->user()->id,
            'product_id' => $product->id,
            'address' => $validated['address'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice
        ]);

        $product->update([
            'stock' => ($product->stock - $validated['quantity'])
        ]);

        return redirect()->route('user.products.view', $product->id)->with('success', 'Your order was placed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
        $this->orderService->cancelOrder($order);

        if ($request->boolean('redirect')) {
            session(['success' => "Order Cancelled Successfully!"]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Deleted Successfully!',
                'redirect' => route('user.orders')
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Order Cancelled Successfully!']);
    }
}
