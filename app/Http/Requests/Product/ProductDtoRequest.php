<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductDtoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'productName' => 'required|min:3|max:100',
            'productDescription' => 'required',
            'quantityInStock' => 'required|numeric',
            'buyPrice' => 'required',
            'MSRP' => 'required',
            'file' => 'required_without|mimes:png,jpg,jpeg|max:2048',
        ];
    }

    /**
     * Get the validation error messages that apply to the request
     *
     * @return array
     */
    public function messages()
    {
        return [
            'productName.required' => 'Please enter product name.',
            'productDescription.required' => 'Please enter product description.',
            'quantityInStock.required' => 'Please enter quantity in stock.',
            'quantityInStock.numeric' => 'Please enter quantity in numeric format.',
            'buyPrice.required' => 'Please enter Buy Price.',
            'MSRP.required' => 'Please enter MSRP.',
            'file.required_without' => 'Please upload file.',
            'file.mimes' => 'Please upload valid file.'
        ];
    }
}
