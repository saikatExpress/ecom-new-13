<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryGatewayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'min:2', 'max:150'],
            'delivery_fee' => ['required', 'numeric'],
            'status'       => ['required', 'in:active,inactive']
        ];
    }
}
