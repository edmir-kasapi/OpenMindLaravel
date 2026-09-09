<?php

namespace App\Http\Controllers\Admin\orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentStatus;
use App\Services\Orders\OrderService;
use App\Services\StripeService;
use Illuminate\Http\Request;

class RejectRefund extends Controller
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
        if($this->orderService->unmarkRefund($id))
        {
            return back()->with('success', 'Refund rejection successful!');
        }

        return back()->with('error', 'Unable to reject refund!');
    }
}
