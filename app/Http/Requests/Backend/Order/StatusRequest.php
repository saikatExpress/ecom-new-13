<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;

        return [
            'name'       => ['required', 'min:2', 'max:150', "unique:statuses,name,$id"],
            'bg_color'   => ['required'],
            'text_color' => ['required'],
            'status'     => ['required', 'in:active, inactive']
        ];
    }
}
