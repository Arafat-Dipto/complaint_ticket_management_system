<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserCreateRequst extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => 'required|min:1|max:255',
            'email'                 => 'nullable|email:rfc,dns|unique:users,email',
            'roles'                 => 'required|array',
            'is_active'             => 'required|integer',
            'password'              => 'required|confirmed|min:6|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=[^!@?\n]*[!@?]).+$/',
            'password_confirmation' => 'required|min:6|max:255',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required'  => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min'       => 'The password must be at least 6 characters.',
            'password.max'       => 'The password may not be greater than 255 characters.',
            'password.regex'     => 'The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',
        ];
    }
}
