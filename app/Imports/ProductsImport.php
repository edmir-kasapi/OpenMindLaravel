<?php

namespace App\Imports;

use App\Http\Requests\Admin\Products\AdminProductRequest;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Services\Products\ProductService;

class ProductsImport extends DocumentImport
{
    protected ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->rules = (new AdminProductRequest())->rules();
    }

    protected function insertRecordToDb($record): void
    {
        $this->productService->createProduct($record);
    }
}
