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
            'customer_name' => ['required', 'min:2'],
            'phone_number' => ['required', 'min:11']
        ];
    }
}
