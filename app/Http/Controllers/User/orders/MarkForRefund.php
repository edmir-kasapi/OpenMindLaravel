<?php

namespace App\Http\Controllers\User\orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;

class MarkForRefund extends Controller
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
        $order = Order::findOrFail($id);
        $this->orderService->markForRefund($order);

        return response()->json(['status' => 'success', 'message' => 'Refund Requested Successfully!']);
    }
}
