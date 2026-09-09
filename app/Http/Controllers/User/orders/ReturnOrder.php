<?php

namespace App\Http\Controllers\User\orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\ShipmentStatus;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class ReturnOrder extends Controller
{
    public function __construct(
        protected OrderService $orderService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(string $id, Request $request)
    {
        if($this->orderService->returnOrder($id))
        {
            return response()->json(['status' => 'success', 'message' => 'Order is now returning!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Could not return order!']);
    }
}
