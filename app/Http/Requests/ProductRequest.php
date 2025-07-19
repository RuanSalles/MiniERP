<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'amount' => ['required', 'decimal:0,2', 'min:0.1'],
            'code' => ['required'],
            'description' => ['string'],
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'Esse código de produto já existe'
        ];
    }
}
