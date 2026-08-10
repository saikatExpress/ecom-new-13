<?php

namespace App\Http\Requests\Backend\CMS;

use Illuminate\Foundation\Http\FormRequest;

class CmsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'min:2', 'max:255'],
            'content' => ['required', 'min:2'],
            'status'  => ['required', 'in:active,inactive']
        ];
    }
}
