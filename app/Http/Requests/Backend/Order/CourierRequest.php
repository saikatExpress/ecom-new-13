<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class CourierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;

        return [
            'name'     => ['required', 'min:2', "unique:couriers,name,$id"],
            'img_path' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp'],
            'status'   => ['required', 'in:active,inactive']
        ];
    }
}
