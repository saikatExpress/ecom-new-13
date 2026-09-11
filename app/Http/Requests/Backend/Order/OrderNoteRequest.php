<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'note'     => ['required','string','max:5000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'order_id' => 'order',
            'note'     => 'note',
        ];
    }
}
