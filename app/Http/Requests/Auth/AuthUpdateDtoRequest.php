<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthUpdateDtoRequest extends FormRequest
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
            'name' => 'required',
            'password' => 'required_without',
            'c_password' => 'required_without|same:password',
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
            'password.required_without' => 'Please enter password.',
            'c_password.required_without' => 'Please enter confirm password.',
            'c_password.same' => 'Password not matched with confirm password.',

        ];
    }
}
