<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class CustomerTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;

        return [
            'name'        => ['required', 'min:2', 'max:100', "unique:customer_types,name,$id"],
            'order_range' => ['required'],
            'status'      => ['required', 'in:active,inactive']
        ];
    }
}
