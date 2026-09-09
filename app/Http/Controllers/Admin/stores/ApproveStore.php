<?php

namespace App\Http\Controllers\Admin\stores;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\Stores\StoreService;
use Illuminate\Http\Request;

class ApproveStore extends Controller
{
    public function __construct(
        protected StoreService $storeService
    )
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Store $store, Request $request)
    {
        $this->storeService->approveStore($store);

        return redirect()->back()->with('success', 'Store approved successfully!');
    }
}
