<?php

namespace App\Http\Requests\Frontend\Order;

use Illuminate\Foundation\Http\FormRequest;

class CouponApplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'               => ['required','string','max:100'],
            'items'              => ['required','array','min:1'],
            'cart_amount'        => ['required','numeric','min:0'],
            'items.*.quantity'   => ['required','integer','min:1'],
            'items.*.product_id' => ['required','integer','exists:products,id'],
        ];
    }
}
