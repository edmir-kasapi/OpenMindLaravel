<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\ProductIndexRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
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
    public function index(ProductIndexRequest $request)
    {
        //dd($request->all());
        $products = $this->productService->getProductCatalog($request);

        return new ProductCollection($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['type', 'pictures']);

        return new ProductResource($product);
    }

}
