<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequst extends FormRequest
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
        $id    = $this->get('id') ?? request()->route('id');
        $rules = [
            'name'      => 'required|min:1|max:255,' . $id,
            'email'     => 'nullable|email:rfc,dns|unique:users,email,' . $id,
            'roles'     => 'required|array',
            'is_active' => 'required|integer',
        ];

        // Only include password rules if it's not null
        if ($this->filled('password')) {
            $rules['password']              = 'confirmed|min:6|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=[^!@?\n]*[!@?]).+$/';
            $rules['password_confirmation'] = 'required_with:password|min:6|max:255';
        }

        return $rules;
    }
}
