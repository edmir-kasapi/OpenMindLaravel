<?php

namespace App\Http\Controllers\Admin\orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class CancelOrder extends Controller
{
    public function __construct(
        protected OrderService $orderService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order, Request $request)
    {
        if($this->orderService->cancelOrder($order))
        {
            return redirect()->back()->with('success', 'Order was cancelled successfully!');
        }

        return redirect()->back()->with('error', 'Could not cancel order!');
    }
}
