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
            'image'       => ['required', 'image', 'mimes:png,jpg,jpeg,webp'],
            'status'      => ['required', 'in:active,inactive']
        ];
    }
}
