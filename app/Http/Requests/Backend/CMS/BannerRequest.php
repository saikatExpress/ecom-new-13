<?php

namespace App\Http\Requests\Backend\CMS;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['nullable', 'string', 'min:2', 'max:150'],
            'link'        => ['nullable', 'url'],
            'img_path'    => ['required', 'image', 'mimes:png,jpg,jpeg,webp','dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000'],
            'device_type' => ['required', 'in:desktop,mobile,tablet'],
            'status'      => ['required', 'in:active,inactive']
        ];
    }
}
