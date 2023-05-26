<?php

namespace App\Http\Requests\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageDtoRequest extends FormRequest
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
            'files' => 'required',
            'files.*' => 'mimes:png,jpg,jpeg,pdf,csv,xls,xlsx,doc,docx|max:2048|dimensions:min_width=200,min_height=100'
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
            'files.*.required' => 'Please upload file.',
            'files.*.mimes' => 'Please upload valid file.',
            'files.*.dimensions' => 'Please upload file with valid dimension (min width=200, min height=100).'
        ];
    }
}
