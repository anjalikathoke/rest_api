<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class OrderShippingDateDtoRequest extends FormRequest
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
            'shippedDate' => 'required|date'
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
            'shippedDate.required' => 'Please enter shipping date.',
            'shippedDate.date' => 'Please enter valid shipping date (Y-m-d)'
        ];
    }
}
