<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$products = $this -> productService -> getProductCatalog($request);

        return view('pages.user.products.main-menu');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('pages.user.products.view-product', ['product' => $product]);
    }
}
