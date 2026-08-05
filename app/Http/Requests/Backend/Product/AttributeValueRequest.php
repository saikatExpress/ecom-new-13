<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attribute_id' => ['required', 'exists:attributes,id'],
            'value'        => ['required', 'min:1', 'max:100']
        ];
    }
}
