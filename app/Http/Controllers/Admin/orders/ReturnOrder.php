<?php

namespace App\Http\Controllers\Admin\orders;

use App\Http\Controllers\Controller;
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
            return redirect()->back()->with('success', 'Order is now returning!');
        }

        return redirect()->back()->with('error', 'Could not return order!');
    }
}
