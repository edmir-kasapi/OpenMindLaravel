<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\Stores\StoreService;
use Illuminate\Http\Request;

class UnapproveStore extends Controller
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
        $this->storeService->disapproveStore($store);

        return redirect()->back()->with('success','Approval retraction successful!');
    }
}
