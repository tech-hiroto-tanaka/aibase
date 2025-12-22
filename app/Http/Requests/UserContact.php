<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserContact extends FormRequest
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
            //
            'hira_first_name' => 'required|max:50',
            'hira_last_name' => 'required|max:50',
            'kata_first_name' => 'required|max:50',
            'kata_last_name' => 'required|max:50',
            'contact_email' => 'required|max:255',
            'contact_phone_number' => 'required',
            'contact_content' => 'required|max:20000',
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
            if (!preg_match($regexTelephone, $data['contact_phone_number']) && !preg_match($regexTelephone1, $data['contact_phone_number']) && !preg_match($regexTelephone2, $data['contact_phone_number']) && !preg_match($regexTelephone3, $data['contact_phone_number'])
                && !preg_match($regexTelephone4, $data['contact_phone_number'])  && !preg_match($regexTelephone5, $data['contact_phone_number'])) {
                $validator->errors()->add('contact_phone_number', "error");
            }
        });
    }
}
