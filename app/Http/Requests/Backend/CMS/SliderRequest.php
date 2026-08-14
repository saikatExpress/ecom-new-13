<?php

namespace App\Http\Requests\Backend\CMS;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['nullable', 'string', 'min:1', 'max:255'],
            'device_type' => ['required', 'in:desktop,mobile,tablet'],
            'image'       => ['required', 'image', 'mimes:png,jpg,jpeg,webp','dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000'],
            'status'      => ['required', 'in:active,inactive']
        ];
    }
}
