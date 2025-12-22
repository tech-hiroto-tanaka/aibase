<?php

namespace App\Http\Requests;

use App\Enums\ItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SkillRequest extends FormRequest
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
            'skill_name' => 'required|max:255',
            'order_number' => [
                'required',
                'regex:/^\d+$/'
            ]
        ];
    }
}
