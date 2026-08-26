<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Foundation\Http\FormRequest;

class CategoryReorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categories'            => ['required', 'array', 'min:1'],
            'categories.*.id'       => ['required','integer','exists:categories,id'],
            'categories.*.position' => ['required','integer','min:1'],
        ];
    }
}
