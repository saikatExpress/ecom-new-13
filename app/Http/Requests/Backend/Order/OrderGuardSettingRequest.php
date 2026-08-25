<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderGuardSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone_order_limit'             => ['required','integer','min:1',],
            'phone_order_period_value'      => ['required','integer','min:1',],
            'phone_order_period_unit'       => ['required', Rule::in(['minute','hour','day','week'])],
            'ip_order_limit'                => ['required','integer','min:1'],
            'ip_order_period_value'         => ['required','integer','min:1'],
            'ip_order_period_unit'          => ['required', Rule::in(['minute','hour','day','week']),],
            'user_token_order_limit'        => ['required','integer','min:1'],
            'user_token_order_period_value' => ['required','integer','min:1'],
            'user_token_order_period_unit'  => ['required', Rule::in(['minute','hour','day','week'])],
            'auto_block_enabled'            => ['required','boolean'],
            'block_after_attempts'          => ['nullable','integer','min:1','required_if:auto_block_enabled,1'],
            'block_duration_value'          => ['nullable','integer','min:1','required_if:auto_block_enabled,1'],
            'block_duration_unit'           => ['nullable',Rule::in(['minute','hour','day','week']), 'required_if:auto_block_enabled,1'],
            'block_message'                 => ['nullable','string','max:255'],
        ];
    }
}
