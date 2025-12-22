<?php

namespace App\Http\Requests;

use App\Enums\ItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->user;
        return [
            'area_id' => [
                'required',
                Rule::in([1, 2, 3, 4, 5, 6, 7, 8])
            ],
            'prefectures' => 'nullable|array',
            'order_number' => [
                'required',
                'regex:/^\d+$/'
            ]
        ];
    }
}
