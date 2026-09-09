<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;
use phpDocumentor\Reflection\Types\Nullable;

class ProductIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    #[Override]
    protected function prepareForValidation()
    {
        $this->mergeIfMissing([
            'min_price' => 0
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'product_type' => ['nullable', 'integer', 'exists:product_types,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'gte:min_price'],
            'stock_level' => ['nullable', Rule::in(['in-stock', 'medium-stock', 'low-stock', 'out-of-stock'])],
            'sort_type' => ['nullable', Rule::in(['name-asc', 'name-desc', 'price-asc', 'price-desc', 'stock-asc', 'stock-desc', 'date-asc', 'date-desc'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100']
        ];
    }
}
