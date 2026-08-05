<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:255']
        ];
    }
}
