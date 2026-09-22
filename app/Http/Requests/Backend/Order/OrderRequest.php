<?php

namespace App\Http\Requests\Backend\Order;

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
            'status_id'                  => ['required','integer','exists:statuses,id'],
            'customer_type_id'           => ['nullable','integer','exists:customer_types,id'],
            'delivery_gateway_id'        => ['nullable','integer','exists:delivery_gateways,id'],
            'payment_gateway_id'         => ['nullable','integer','exists:payment_gateways,id'],
            'coupon_id'                  => ['nullable','integer','exists:coupons,id'],
            'courier_id'                 => ['nullable','integer','exists:couriers,id'],
            'pickup_store_id'            => ['nullable','integer'],
            'item_weight'                => ['nullable'],
            'customer_name'              => ['required','string','max:255'],
            'phone_number'               => ['required','string','max:30'],
            'shipping_address'           => ['required','string','max:5000'],
            'district_id'                => ['nullable','integer','exists:districts,id'],
            'items'                      => ['required','array','min:1'],
            'items.*.product_id'         => ['required','integer', 'exists:products,id'],
            'items.*.product_variant_id' => ['nullable','integer', 'exists:product_variants,id'],
            'items.*.quantity'           => ['required','integer','min:1'],
            'advanced_payment'           => ['nullable','numeric','min:0'],
            'special_discount'           => ['nullable','numeric','min:0'],
            'coupon_discount'            => ['nullable','numeric','min:0'],
            'delivery_charge'            => ['nullable','numeric','min:0'],
            'additional_cost'            => ['nullable','numeric','min:0'],
            'delivery_type'              => ['nullable','integer'],
            'note'                       => ['nullable','string','max:1024'],
        ];
    }
}
