<?php

namespace App\Http\Requests\Frontend\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'idempotency_key'     => ['required','string','uuid','max:100'],
            'customer_name'       => ['required', 'min:2'],
            'phone_number'        => ['required', 'min:11'],
            'shipping_address'    => ['required', 'min:2', 'max:255'],
            'delivery_gateway_id' => ['required','exists:delivery_gateways,id'],
            'payment_gateway_id'  => ['required','exists:payment_gateways,id'],
            'coupon_id'           => ['nullable','exists:coupons,id'],
            'utm_source'          => ['nullable','string','max:255'],
        ];
    }
}
