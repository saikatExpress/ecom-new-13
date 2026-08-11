<?php

namespace App\Http\Requests\Backend\CMS;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'min:2'],
            'answer'   => ['required', 'string', 'min:2'],
            'status'   => ['required', 'in:active,inactive'],
        ];
    }
}
