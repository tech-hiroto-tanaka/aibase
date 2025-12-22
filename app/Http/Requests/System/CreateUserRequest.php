<?php

namespace App\Http\Requests\System;

use App\Enums\DesiredWorkType;
use App\Enums\Gender;
use App\Models\Area;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'hira_first_name' => 'required|max:50',
            'hira_last_name' => 'required|max:50',
            'kata_first_name' => 'required|max:50',
            'kata_last_name' => 'required|max:50',
            'birthday' => 'required|date_format:Y/m/d',
            'gender' => [
                'required',
                Rule::in(Gender::getValues())
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNotNull('email_verified_at')->whereNull('deleted_at');
                })
            ],
            'phone_number' => 'required',
            'area_id' => [
                'required',
                Rule::in(Area::pluck('id'))
            ],
            'password' => [
                'required',
                'max:32',
                'min:8',
                'regex:/^[a-zA-Z0-9!-:-@¥[-`{-~]*$/'
            ],
            'desired_work_type' => [
                'nullable',
                Rule::in(DesiredWorkType::getValues())
            ],
            'experience_skills_from_date' => 'nullable|date_format:Y/m/d',
            'experience_skills_detail' => 'nullable|max:20000',
            'nearest_station_name' => 'nullable|max:255',
            'other_requests' => 'nullable|max:20000'
        ];
    }

    public function withValidator($validator)
    {
        $data = $this->all();
        return $validator->after(function ($validator) use ($data) {
            preg_match('/([\p{Katakana}]+)/mu', $data['kata_first_name'], $matches);
            if (!$matches) {
                $validator->errors()->add('kata_first_name', "error");
            }
            preg_match('/([\p{Katakana}]+)/mu', $data['kata_last_name'], $matches);
            if (!$matches) {
                $validator->errors()->add('kata_last_name', "error");
            }
        });
    }
}
