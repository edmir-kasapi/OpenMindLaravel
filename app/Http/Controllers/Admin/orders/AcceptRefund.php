<?php

namespace App\Http\Controllers\Admin\orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\ShipmentStatus;
use App\Services\Orders\OrderService;
use App\Services\Stripe\StripeService;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class AcceptRefund extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected StripeService $stripeService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(string $id, Request $request)
    {
        $order = $this->stripeService->processOrderRefund($id);

        if($order)
        {
            $this->orderService->markOrderAsRefunded($order);
            return back()->with('success', 'Order refunded successfully!');
        }

        return back()->with('error', 'Order could not be refunded!');

    }
}
