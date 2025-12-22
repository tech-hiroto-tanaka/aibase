<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Enums\Gender;
use App\Enums\DesiredWorkType;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $userId = Auth::guard('user')->user()->id;

        return [
            'hira_first_name' => 'required|max:50',
            'hira_last_name' => 'required|max:50',
            'kata_first_name' => 'required|max:50',
            'kata_last_name' => 'required|max:50',
            'birthday' => 'required',
            'gender' => [
                'required',
                Rule::in(Gender::getValues())
            ],
            'email' => [
                'required',
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
            // 'experience_skills_from_date' => 'required',
            'experience_skills_detail' => 'max:20000',
            'nearest_station_name' => 'nullable|max:255',
            'other_requests' => 'nullable|max:20000'
        ];
    }
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $data = $this->all();
        return $validator->after(function ($validator) use ($data) {
            if (!preg_match("/^[0-9]{4}\/([1-9]|0[1-9]|1[0-2])\/([1-9]|0[1-9]|[1-2][0-9]|3[0-1])$/", $data['birthday'])) {
                $validator->errors()->add('birthday', "error");
            } else {
                $birthday = Carbon::parse($data['birthday']);
                $birthdaySlipt = explode("/", $data['birthday']);
                if ($birthday->year != (int)$birthdaySlipt[0] || $birthday->month != (int)$birthdaySlipt[1] || $birthday->day != (int)$birthdaySlipt[2]) {
                    $validator->errors()->add('birthday', "error");
                }
            }
            $regexTelephone = "/^0(\d-\d{4}-\d{4})$/";
            $regexTelephone1 = "/^0(\d{3}-\d{2}-\d{4})$/";
            $regexTelephone2 = "/^0(\d{2}-\d{3}-\d{4})$/";
            $regexTelephone3 = "/^(070|080|090|050)(-\d{4}-\d{4})$/";
            $regexTelephone4 = "/^(070|080|090|050)(\d{8})$/";
            $regexTelephone5 = "/^0(\d{9})$/";
            if (!preg_match($regexTelephone, $data['phone_number']) && !preg_match($regexTelephone1, $data['phone_number']) && !preg_match($regexTelephone2, $data['phone_number']) && !preg_match($regexTelephone3, $data['phone_number'])
                && !preg_match($regexTelephone4, $data['phone_number'])  && !preg_match($regexTelephone5, $data['phone_number'])) {
                $validator->errors()->add('phone_number', "error");
            }

            preg_match('/([\p{Katakana}]+)/mu', $data['kata_first_name'], $matches);
            if (!$matches) {
                $validator->errors()->add('kata_first_name', "error");
            }
            preg_match('/([\p{Katakana}]+)/mu', $data['kata_last_name'], $matches);
            if (!$matches) {
                $validator->errors()->add('kata_last_name', "error");
            }
            // if (isset($data['experience_skills_from_date']) && $data['experience_skills_from_date']) {
            //     if (!preg_match("/^[0-9]{4}\/([1-9]|0[1-9]|1[0-2])\/([1-9]|0[1-9]|[1-2][0-9]|3[0-1])$/", $data['experience_skills_from_date'])) {
            //         $validator->errors()->add('experience_skills_from_date', "error");
            //     } else {
            //         $skillDate = Carbon::parse($data['experience_skills_from_date']);
            //         $dateSlipt = explode("/", $data['experience_skills_from_date']);
            //         if ($skillDate->year != (int)$dateSlipt[0] || $skillDate->month != (int)$dateSlipt[1] || $skillDate->day != (int)$dateSlipt[2]) {
            //             $validator->errors()->add('experience_skills_from_date', "error");
            //         }
            //     }
            // }
        });
    }
}
