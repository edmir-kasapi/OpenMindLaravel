<?php

namespace App\Http\Controllers\Admin\orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class MarkConfirmed extends Controller
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
        if($this->orderService->markOrderAsConfirmed($order))
        {
            return redirect()->back()->with('success', 'Order is now confirmed');
        }

        return redirect()->back()->with('error', 'Order could not be confirmed');
    }
}
