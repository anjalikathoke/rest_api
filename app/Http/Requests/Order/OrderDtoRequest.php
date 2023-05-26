<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use App\Rules\OrderDetailValidation;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class OrderDtoRequest extends FormRequest
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
            'customerNumber' => 'required',
            'orderDetail' => ['required', 'array', new OrderDetailValidation]
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
            'customerNumber.required' => 'Please enter customer number.',
            'orderDetail' => 'Please enter proper product details'
        ];
    }
}
