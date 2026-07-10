<?php

namespace App\Http\Requests\Backend\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reset_token' => ['required', 'string'],
            'password'    => ['required', 'confirmed', 'min:8'],
        ];
    }
}
