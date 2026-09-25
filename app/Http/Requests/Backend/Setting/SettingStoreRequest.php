<?php

namespace App\Http\Requests\Backend\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'group_name'  => ['required','string','max:100'],
            'setting_key' => ['required','string','max:150'],
            'label'       => ['required','string','max:255'],
            'value'       => ['nullable'],
            'type'        => ['required','string','in:string,number,boolean,email,textarea,image,color,select,url'],
            'autoload'    => ['nullable','boolean'],
        ];
    }
}
