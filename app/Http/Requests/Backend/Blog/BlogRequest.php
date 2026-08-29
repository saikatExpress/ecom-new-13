<?php

namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ["required", "min:2"],
            'category_id' => ["required", 'exists:blog_categories,id'],
            'image'       => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp','dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000'],
            'status'      => ['required', 'in:active,inactive']
        ];
    }
}
