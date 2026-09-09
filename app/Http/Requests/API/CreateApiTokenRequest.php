<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateApiTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('store')->operator_id === auth()->user()->id
            && $this->route('store')->is_approved;
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
            'abilities' => ['required', 'array', 'min:1'],
            'abilities.*' => [
                'required',
                'string',
                Rule::in([
                    'products:read',
                    'collections:read',
                ]),
            ],
            'duration' => [
                'required',
                'string',
                Rule::in([
                    'never',
                    '30',
                    '90',
                    '365',
                ]),
            ],
        ];
    }
}
