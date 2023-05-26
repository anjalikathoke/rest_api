<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthDtoRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
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
            'name.required' => 'Please enter name.',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email.',
            'password.required' => 'Please enter password.',
            'c_password.required' => 'Please enter confirm password.',
            'c_password.same' => 'Password not matched with confirm password.',

        ];
    }
}
