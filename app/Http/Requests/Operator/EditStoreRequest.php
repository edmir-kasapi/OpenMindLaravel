<?php

namespace App\Http\Requests\Operator;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditStoreRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('store')->operator_id === auth()->user()->id
            || auth()->user()->hasRole(['Admin']);
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
            'phone' => ['required', 'regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/', ],
            'domain' => ['required', 'url', 'unique:stores,domain,'.$this->route('store')->id.',id'] //to check for a real address, use "active_url"
        ];
    }
}
