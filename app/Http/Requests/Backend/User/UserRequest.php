<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;

        return [
            'username'         => ['required', 'min:2', 'max:255'],
            'phone_number'     => ['required', 'min:11', 'max:20', "unique:users,phone_number,$id"],
            'email'            => ['nullable', 'email', "unique:users,email,$id"],
            'user_category_id' => ['required', 'exists:user_categories,id'],
            'password'         => $this->isMethod('POST') ? ['required', 'string', 'min:8'] : ['nullable', 'string', 'min:8'],
            'image'            => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp'],
            'status'           => ['required', 'in:active,inactive']
        ];
    }
}
