<?php

namespace App\Http\Requests\Customer;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerDtoRequest extends FormRequest
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
            'contactFirstName' => 'required|min:3|max:50',
            'contactLastName' => 'required|min:3|max:50',
            'phone' => ['required', Rule::unique('customers')->ignore($this->customer,'customerNumber')],
            'addressLine1' => 'required',
            'addressLine2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postalCode' => 'required|numeric',
            'country' => 'required'
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
            'contactFirstName.required' => 'Please enter first name.',
            'contactFirstName.min' => 'You must have to enter at least 3 letters.',
            'contactFirstName.max' => 'Please enter maximun 50 letters only.',
            'contactLastName.required' => 'Please enter last name.',
            'contactLastName.min' => 'You must have to enter at least 3 letters.',
            'contactLastName.max' => 'Please enter maximun 50 letters only.',
            'phone.required' => 'Please enter name.',
            'addressLine1.required' => 'Please enter name.',
            'addressLine2.required' => 'Please enter name.',
            'city.required' => 'Please enter name.',
            'state.required' => 'Please enter name.',
            'postalCode.required' => 'Please enter name.',
            'postalCode.numeric' => 'Please enter number only.',
            'country.required' => 'Please enter country name.'
        ];
    }
}
