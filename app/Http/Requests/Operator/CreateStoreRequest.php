<?php

namespace App\Http\Requests\Operator;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/'],
            'domain' => ['required', 'url', 'unique:stores,domain'] //to check for a real address, use "active_url"
        ];
    }
}
