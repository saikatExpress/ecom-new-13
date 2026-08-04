<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'min:2', 'max:255'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp','max:2048','dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000'],
            'status'      => $this->isMethod('PUT') ? ['required', 'in:active,inactive'] : ['nullable']
        ];
    }
}
