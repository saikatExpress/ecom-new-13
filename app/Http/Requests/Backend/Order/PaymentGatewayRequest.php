<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;

        return [
            'name'         => ['required', 'min:2', 'max:200', "unique:payment_gateways,name,$id"],
            'phone_number' => ['nullable', 'min:11', 'max:15'],
            'image'        => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp'],
            'status'       => ['in:active,inactive']
        ];
    }
}
