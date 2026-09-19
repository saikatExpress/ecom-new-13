<?php

namespace App\Http\Requests\Backend\AI\Provider;

use Illuminate\Foundation\Http\FormRequest;

class AiProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'min:2'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
