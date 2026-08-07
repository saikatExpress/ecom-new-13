<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                          => ['required', 'string', 'max:255'],
            'category_id'                   => ['required', 'exists:categories,id'],
            'sub_category_id'               => ['nullable', 'exists:sub_categories,id'],
            'brand_id'                      => ['nullable', 'exists:brands,id'],
            'sku'                           => ['nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($this->route('id')),],
            'image'                         => ['required', 'image', 'mimes:png,jpg,jpeg,webp'],
            'buy_price'                     => ['nullable', 'numeric', 'min:0'],
            'mrp'                           => ['required', 'numeric', 'min:0'],
            'sell_price'                    => ['required', 'numeric', 'min:0', 'lte:mrp'],
            'discount_amount'               => ['nullable', 'numeric', 'min:0'],
            'offer_price'                   => ['nullable', 'numeric', 'min:0'],
            'current_stock'                 => ['nullable', 'integer', 'min:0'],
            'short_description'             => ['nullable', 'string'],
            'description'                   => ['nullable', 'string'],
            'meta_title'                    => ['nullable', 'string', 'max:255'],
            'meta_description'              => ['nullable', 'string'],
            'meta_keywords'                 => ['nullable', 'string'],
            'status'                        => ['required', 'string', 'in:active,inactive'],
            'gallery_images'                => ['nullable', 'array'],
            'gallery_images.*'              => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'variants'                      => ['nullable', 'array'],
            'variants.*.sku'                => ['nullable', 'string', 'max:100', 'distinct'],
            'variants.*.buy_price'          => ['nullable', 'numeric', 'min:0'],
            'variants.*.mrp'                => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.sell_price'         => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.discount_type'      => ['nullable', 'string', 'in:fixed,percentage'],
            'variants.*.discount_amount'    => ['nullable', 'numeric', 'min:0'],
            'variants.*.offer_price'        => ['nullable', 'numeric', 'min:0'],
            'variants.*.current_stock'      => ['required_with:variants', 'integer', 'min:0'],
            'variants.*.attribute_values'   => ['required_with:variants', 'array'],
            'variants.*.attribute_values.*' => ['exists:attribute_values,id'],
        ];
    }
}
