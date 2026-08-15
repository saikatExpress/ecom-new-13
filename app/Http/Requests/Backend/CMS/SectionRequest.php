<?php

namespace App\Http\Requests\Backend\CMS;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'min:2', 'max:150'],
            'is_slider' => ['required', 'boolean'],
            'status'    => ['required', 'in:active,inactive']
        ];
    }
}
