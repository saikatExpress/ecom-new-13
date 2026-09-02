<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class StatusReorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status_ids'   => ['required','array','min:1'],
            'status_ids.*' => ['required','integer','distinct','exists:statuses,id'],
        ];
    }
}
