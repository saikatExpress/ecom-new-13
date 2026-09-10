<?php

namespace App\Http\Requests\Backend\AI\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductAiGenerateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => ['nullable','string','max:255'],
            'category'          => ['nullable','string','max:255'],
            'sub_category'      => ['nullable','string','max:255'],
            'brand'             => ['nullable','string','max:255'],
            'sku'               => ['nullable','string','max:100'],
            'mrp'               => ['nullable','numeric','min:0'],
            'sell_price'        => ['nullable','numeric','min:0'],
            'free_shipping'     => ['nullable','boolean'],
            'short_description' => ['nullable','string','max:2000'],
            'description'       => ['nullable','string','max:20000'],
            'prompt'            => ['required','string','min:5','max:5000','not_regex:/^(\d)\1+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'prompt.required' => 'Please provide a product prompt.',
            'prompt.min'      => 'Product prompt must be at least 5 characters.',
            'prompt.max'      => 'Product prompt may not be greater than 5000 characters.',
        ];
    }
}
