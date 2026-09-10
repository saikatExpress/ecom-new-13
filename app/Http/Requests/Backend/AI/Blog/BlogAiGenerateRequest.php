<?php

namespace App\Http\Requests\Backend\AI\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogAiGenerateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt' => ['required','string','min:5','max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'prompt.required' => 'Please provide a prompt.',
            'prompt.min'      => 'Prompt must be at least 5 characters.',
            'prompt.max'      => 'Prompt may not be greater than 5000 characters.',
        ];
    }
}
