<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CancelReasonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => ['required', 'min:2', 'max:150'],
            'status' => ['required', 'in:active,inactive']
        ];
    }
}
