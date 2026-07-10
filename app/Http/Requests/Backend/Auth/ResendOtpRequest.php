<?php

namespace App\Http\Requests\Backend\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResendOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone_number' => ['required', 'string', 'exists:users,phone_number'],
            'purpose'      => ['required', 'string'],
        ];
    }
}
