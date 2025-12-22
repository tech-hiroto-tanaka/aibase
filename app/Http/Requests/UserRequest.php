<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\DesiredWorkType;
use App\Models\Area;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->user;

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
                Rule::unique('users')->where(function ($query) use ($userId) {
                    return $query->whereNotNull('email_verified_at')->whereNull('deleted_at')->where('id', '!=', $userId);
                })
            ],
            'phone_number' => 'required',
            'area_id' => [
                'required',
                Rule::in(Area::pluck('id'))
            ],
            'password' => [
                'nullable',
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
            'other_requests' => 'nullable|max:20000',
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
            $regexTelephone = "/^0(\d-\d{4}-\d{4})$/";
            $regexTelephone1 = "/^0(\d{3}-\d{2}-\d{4})$/";
            $regexTelephone2 = "/^0(\d{2}-\d{3}-\d{4})$/";
            $regexTelephone3 = "/^(070|080|090|050)(-\d{4}-\d{4})$/";
            $regexTelephone4 = "/^(070|080|090|050)(\d{8})$/";
            $regexTelephone5 = "/^0(\d{9})$/";
            if (!preg_match($regexTelephone, $data['phone_number']) && !preg_match($regexTelephone1, $data['phone_number']) && !preg_match($regexTelephone2, $data['phone_number']) && !preg_match($regexTelephone3, $data['phone_number'])
                && !preg_match($regexTelephone4, $data['phone_number'])  && !preg_match($regexTelephone5, $data['phone_number'])) {
                $validator->errors()->add('experience_skills_from_date', "error");
            }
        });
    }
}
