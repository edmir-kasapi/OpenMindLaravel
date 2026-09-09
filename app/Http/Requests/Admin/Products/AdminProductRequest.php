<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole(['Admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'max:300'],
            "brand" => ['required', 'string', 'max:300'],
            "price" => ['required', 'numeric', 'gt:0'],
            "product_type" => ['required', 'integer', 'exists:product_types,id'],
            "stock" => ['required', 'integer', 'between:0,10000000'],
            "description" => ['required', 'min:10', 'max:4000'],
            "product_photos" => ['sometimes', 'array'],
            "product_photos.*" => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,webp']
        ];
    }
}
