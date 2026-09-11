<?php

namespace App\Http\Requests\Backend\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $districtId = $this->route('id');

        return [
            'division_name' => ['required', 'string', 'max:100'],
            'district_name' => ['required','string','max:100', Rule::unique('districts', 'district_name')
                    ->where(function ($query) {
                        return $query->where('division_name',$this->input('division_name'));
                    })
                    ->ignore($districtId),
            ],

            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
