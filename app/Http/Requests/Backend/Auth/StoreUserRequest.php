<?php

namespace App\Http\Requests\Backend\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'         => 'required|string|max:255|unique:users',
            'email'            => 'nullable|email|max:255|unique:users',
            'phone_number'     => 'required|string|max:255|unique:users',
            'password'         => 'required|string|max:255',
            'confirm_password' => 'required|string|max:255|same:password',
            'img_path'         => 'nullable|string|max:255',
            'status'           => 'required|string|max:255',
            'created_by'       => 'nullable|integer',
            'updated_by'       => 'nullable|integer',
            'deleted_by'       => 'nullable|integer',
        ];
    }
}
