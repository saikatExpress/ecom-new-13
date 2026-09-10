<?php

namespace App\Http\Requests\Backend\AI\Ecommerce;

use Illuminate\Foundation\Http\FormRequest;

class EcommerceAiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => ['required','string','min:10','max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Please enter a message.',
            'message.min'      => 'Message must be at least 2 characters.',
            'message.max'      => 'Message may not be greater than 5000 characters.',
        ];
    }
}
