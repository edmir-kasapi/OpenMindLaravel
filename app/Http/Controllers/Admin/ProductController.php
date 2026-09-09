<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\AdminProductRequest;
use App\Models\Product;
use App\Services\Media\ProductPhotoService;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ProductPhotoService $productPhotoService
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this -> productService -> getProductsData($request);
        }

        return view('pages.admin.products.products');
    }

    public function trashIndex(Request $request)
    {
        if ($request->ajax()) {
            return $this -> productService -> getTrashedProductsData($request);
        }

        return view('pages.admin.products.products-trashed');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.products.create-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        if($request->file('product_photos') !== null)
        {
           $files = $request->file('product_photos');

           foreach($files as $file)
            {
                $this -> productPhotoService -> uploadProductPhoto($file, $product);
            }
        }

        return redirect()->route('admin.products.create')->with('success', 'product created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return View('pages.admin.products.edit-product', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminProductRequest $request, Product $product)
    {
        $this->productService->updateProduct($product, $request->validated());

        return redirect()->route('admin.products.inspect', $product->id)->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
    */

    public function destroy(Product $product, Request $request)
    {

        $this -> productService -> deleteProduct($product);

        if ($request->boolean('redirect')) {
            session(['success' => "Product deleted successfully!"]);
            return response()->json([
                'status' => 'success',
                'message' => 'Product Deleted Successfully!',
                'redirect' => route('admin.products')
            ]);
        }

        //return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
        return response()->json(['status' => 'success', 'message' => 'Product Deleted Successfully!']);
    }

    public function restore(string $id)
    {
        $this -> productService -> restoreProduct(Product::onlyTrashed()->findOrFail($id));

        return response()->json(['status' => 'success', 'message' => 'Product restored successfully!']);
    }

    /**
     * Force delete the specified resource from storage.
    */
    public function forceDelete(string $id, Request $request)
    {
        $product = Product::onlyTrashed()->with('pictures')->findOrFail($id);

        if($product->pictures->count())
        {
           foreach($product->pictures as $picture)
            {
                $this -> productPhotoService -> deleteProductPhoto($picture);
            }
        }

        $this->productService->forceDeleteProduct($product);

        if ($request->boolean('redirect')) {
           return response()->json([
            'status' => 'success',
            'message' => 'Product Deleted Successfully!',
            'redirect' => route('admin.products')
           ]);
        }

        //return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
        return response()->json(['status' => 'success', 'message' => 'Product Deleted Successfully!']);
    }

}
