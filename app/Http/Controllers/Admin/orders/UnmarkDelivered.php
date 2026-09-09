<?php

namespace App\Http\Controllers\Admin\orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShipmentStatus;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class UnmarkDelivered extends Controller
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
        if($this->orderService->unmarkDeliveredOrder($order))
        {
            return redirect()->back()->with('success', 'Order is back to being shipped!');
        }

        return redirect()->back()->with('error', 'Unable to undo delivery!');
    }
}
