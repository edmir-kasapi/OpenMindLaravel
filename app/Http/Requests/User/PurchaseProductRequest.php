<?php

namespace App\Http\Requests\User;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseProductRequest extends FormRequest
{

    protected ?Product $product = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole(['User']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'address' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1']
        ];
    }

    public function product(): ?Product
    {
        return $this->product ??= Product::find($this->product_id);
    }

    public function after(): array
    {
        return[
            function ($validator){

                $product = $this->product();

                if(!$product)
                {
                    return;
                }

                if($this->quantity > $product->available_stock)
                {
                    $validator->errors()->add('quantity','Not enough stock available!');
                }
            }
        ];
    }

}
