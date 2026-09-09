<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PurchaseProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\Orders\OrderService;
use App\Services\Stripe\StripeService;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class StripeController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected StripeService $stripeService
    )
    {

    }

    public function index(PurchaseProductRequest $request)
    {
        $validated = $request->validated();
        $product = $request->product();

        $order = $this -> orderService -> createOrder($product, $validated);

        return $request->user()->checkoutCharge((int) round($product->price * 100), $product->name, $order->quantity, [
            'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout-cancel').'?session_id={CHECKOUT_SESSION_ID}',
            'metadata' => [
                    'order_id' => (string)$order->id,
                    'product_id' => (string)$order->product_id
                    ],
            'payment_intent_data' => [
                'metadata' => [
                    'order_id' => (string)$order->id,
                    'product_id' => (string)$order->product_id
                    ],
            ]
        ]);

    }

    public function retry(string $id, Request $request)
    {
        $order = Order::with('product')->findOrFail($id);

        return $request->user()->checkoutCharge((int) round($order->product->price * 100), $order->product->name, $order->quantity, [
            'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout-cancel').'?session_id={CHECKOUT_SESSION_ID}',
            'metadata' => [
                    'order_id' => (string)$order->id,
                    'product_id' => (string)$order->product_id
                    ],
            'payment_intent_data' => [
                'metadata' => [
                    'order_id' => (string)$order->id,
                    'product_id' => (string)$order->product_id
                    ],
            ]
        ]);
    }

    public function success(Request $request)
    {
        $order = $this->stripeService->processCheckoutConfirmation($request->session_id);

        if(!$order)
        {
            abort(404);
        }

        return view('pages.checkout.success', ['order' => $order]);
    }

    public function cancel(Request $request)
    {
        $order = $this->stripeService->processCheckoutCancellation($request->session_id);

        if(!$order)
        {
            abort(404);
        }

        return view('pages.checkout.cancel', ['order' => $order]);
    }
}
