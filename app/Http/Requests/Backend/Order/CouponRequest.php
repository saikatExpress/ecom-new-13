<?php

namespace App\Http\Requests\Backend\Order;

use App\Enums\StatusEnum;
use App\Enums\DiscountTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'                => ['required','string','max:255','unique:coupons,code,' . $this->route('id')],
            'discount_type'       => ['required',Rule::in([DiscountTypeEnum::FIXED,DiscountTypeEnum::PERCENTAGE])],
            'discount_value'      => ['required','numeric','gt:0'],
            'apply_scope'         => ['required',Rule::in(['all_products','selected_products','selected_categories'])],
            'product_ids'         => ['required_if:apply_scope,selected_products','nullable','array','min:1'],
            'product_ids.*'       => ['integer','distinct','exists:products,id'],
            'category_ids'        => ['required_if:apply_scope,selected_categories','nullable','array','min:1'],
            'category_ids.*'      => ['integer','distinct','exists:categories,id'],
            'min_order_amount'    => ['nullable','numeric','gte:0'],
            'max_discount_amount' => ['nullable','numeric','gt:0'],
            'usage_limit'         => ['nullable','integer','min:1'],
            'per_phone_limit'     => ['nullable','integer','min:1'],
            'starts_at'           => ['nullable','date'],
            'expires_at'          => ['nullable','date','after_or_equal:starts_at'],
            'status'              => ['required',Rule::in([StatusEnum::ACTIVE,StatusEnum::INACTIVE])],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->discount_type === DiscountTypeEnum::PERCENTAGE && $this->discount_value > 100) {
                $validator->errors()->add('discount_value','Percentage discount cannot be greater than 100.');
            }

            if ($this->discount_type === DiscountTypeEnum::FIXED && $this->filled('max_discount_amount')) {
                $validator->errors()->add('max_discount_amount','Maximum discount amount is only applicable for percentage coupons.');
            }

            if ($this->apply_scope === 'all_products') {

                if ($this->filled('product_ids')) {
                    $validator->errors()->add('product_ids','Product IDs are not allowed for all products scope.');
                }

                if ($this->filled('category_ids')) {
                    $validator->errors()->add('category_ids', 'Category IDs are not allowed for all products scope.');
                }
            }

            if ($this->apply_scope === 'selected_products') {

                if ($this->filled('category_ids')) {
                    $validator->errors()->add('category_ids', 'Category IDs are not allowed for selected products scope.');
                }
            }

            if ($this->apply_scope === 'selected_categories') {

                if ($this->filled('product_ids')) {
                    $validator->errors()->add('product_ids', 'Product IDs are not allowed for selected categories scope.');
                }
            }
        });
    }
}
