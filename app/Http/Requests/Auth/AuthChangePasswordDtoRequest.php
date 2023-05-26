<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthChangePasswordDtoRequest extends FormRequest
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
            'old_password' => ["required"],
            'password' => 'required',
            'c_password' => 'required|same:password',
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
            'old_password.required' => 'Please enter old password.',
            'password.required' => 'Please enter password.',
            'c_password.required' => 'Please enter confirm password.',
            'c_password.same' => 'Password not matched with confirm password.',

        ];
    }
}
