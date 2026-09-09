<?php

namespace App\Services\Products;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getProductsData(Request $request)
    {
        $products = Product::query()
            ->category($request->product_type)
            ->filterStock($request->stock_level);
        return DataTables::eloquent($products)
            ->addColumn('type', function ($product) {
                return view('components.datatable.badges.product-type-badge', ['type' => $product->type->getTypeName()]);
            })
            ->addColumn('stock', function ($product) {
                return view('components.datatable.badges.stock-level-badge', ['stock' => $product->stock]);
            })
            ->addColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format('d-m-Y');
            })
            ->addColumn('action', function ($product) {
                return view('components.datatable.buttons.groups.active-products-button-group', ['id' => $product->id]);
            })
            ->make(true);
    }

    public function getTrashedProductsData(Request $request)
    {
        $products = Product::onlyTrashed()
            ->category($request->product_type)
            ->filterStock($request->stock_level);
        return DataTables::eloquent($products)
            ->addColumn('type', function ($product) {
                return view('components.datatable.badges.product-type-badge', ['type' => $product->type->getTypeName()]);
            })
            ->addColumn('stock', function ($product) {
                return view('components.datatable.badges.stock-level-badge', ['stock' => $product->stock]);
            })
            ->addColumn('deleted_at', function ($user) {
                return Carbon::parse($user->created_at)->format('d-m-Y');
            })
            ->addColumn('action', function ($product) {
                return view('components.datatable.buttons.groups.deleted-products-button-group', ['id' => $product->id]);
            })
            ->make(true);
    }

    public function getProductCatalog(Request $request)
    {
        return Product::query()
            ->with(['type', 'pictures'])
            ->searchName($request->name)
            ->searchBrand($request->brand)
            ->category($request->product_type)
            ->filterStock($request->stock_level)
            ->minPrice($request->min_price)
            ->maxPrice($request->max_price)
            ->sortBy($request->sort_type)
            ->paginate($request->integer('per_page', 10))
            ->withQueryString();
    }

    public function getProductCatalogForLivewire(
        ?string $name = null,
        ?string $brand = null,
        ?string $productType = null,
        ?string $stockLevel = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $sortType = null,
        int $perPage = 10
    )
    {
        return Product::query()
            ->with(['type', 'pictures'])
            ->searchName($name)
            ->searchBrand($brand)
            ->category($productType)
            ->filterStock($stockLevel)
            ->minPrice($minPrice)
            ->maxPrice($maxPrice)
            ->sortBy($sortType)
            ->paginate($perPage);
    }

    public function getTrashedProductCatalogForLivewire(
        ?string $name = null,
        ?string $brand = null,
        ?string $productType = null,
        ?string $stockLevel = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $sortType = null,
        int $perPage = 10
    )
    {
        return Product::onlyTrashed()
            ->with(['type', 'pictures'])
            ->searchName($name)
            ->searchBrand($brand)
            ->category($productType)
            ->filterStock($stockLevel)
            ->minPrice($minPrice)
            ->maxPrice($maxPrice)
            ->sortBy($sortType)
            ->paginate($perPage);
    }

    public function createProduct(array $data)
    {
        $product = Product::create([
            'name' =>  $data['name'],
            'brand' =>  $data['brand'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'available_stock' => $data['stock'],
            'description' => $data['description'],
            'type_id' => $data['product_type']
        ]);

        return $product;
    }

    public function updateproduct(Product $product, array $data)
    {
        $product->update([
            'name' =>  $data['name'],
            'brand' =>  $data['brand'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'],
            'type_id' => $data['product_type']
        ]);
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
    }

    public function restoreProduct(Product $product)
    {
        $product->restore();
    }

    public function forceDeleteProduct(Product $product)
    {
        $product->forceDelete();
    }

    public function exportProducts(Builder $query)
    {
        return new ProductsExport($query);
    }

    public function exportTrashedProducts(Builder $query)
    {
        return new ProductsExport(
            $query,
            true
        );
    }

    public function importProducts(UploadedFile $file)
    {
        (new ProductsImport)->import($file);
    }
}
