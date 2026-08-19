<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;

        return [
            'name'   => ['required', 'min:2', 'max:100', "unique:order_sources,name,$id"],
            'status' => ['required', 'in:active,inactive']
        ];
    }
}
