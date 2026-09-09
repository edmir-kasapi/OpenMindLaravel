<?php

namespace App\Services\Media;

use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductPhotoService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function uploadProductPhoto(mixed $photo, Product $product)
    {

        Storage::disk('public')->put('products', $photo); //new file is uploaded

        ProductPhoto::create([
            'hashed_name' => $photo->hashName(),
            'original_name' => $photo->getClientoriginalName(),
            'extension' => $photo->extension(),
            'size' => $photo->getSize(),
            'product_id' => $product->id
        ]);

    }

    public function deleteProductPhoto(ProductPhoto $photo)
    {
        Storage::disk('public')->delete(['products/' . $photo->getSrc()]);

        $photo->delete();
    }
}
