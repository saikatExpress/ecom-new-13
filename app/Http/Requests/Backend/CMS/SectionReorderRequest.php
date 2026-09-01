<?php

namespace App\Http\Requests\Backend\CMS;

use Illuminate\Foundation\Http\FormRequest;

class SectionReorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section_ids'   => ['required','array','min:1'],
            'section_ids.*' => ['required','integer','distinct','exists:sections,id'],
        ];
    }
}
