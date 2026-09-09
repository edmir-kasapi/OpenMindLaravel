<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\AddPicturesRequest;
use App\Http\Requests\Admin\Media\RemoveProductPhotoRequest;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Services\Media\ProductPhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function __construct(
        protected ProductPhotoService $productPhotoService
    )
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product, AddPicturesRequest $request)
    {
        if($request->file('product_photos') !== null)
        {
            $files = $request->file('product_photos');

            foreach($files as $file)
            {
                $this -> productPhotoService -> uploadProductPhoto($file, $product);
            }

        }

        return redirect()->route('admin.products.inspect', $product->id)->with('success', 'Photos uploaded successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, RemoveProductPhotoRequest $request)
    {
        $photo = ProductPhoto::findOrFail($id);

        $this -> productPhotoService -> deleteProductPhoto($photo);

        return redirect()->back()->with('success', 'photo removed successfully');

    }
}
