<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailScheduleRequest extends FormRequest
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
        return [
            'mail_from_user_name' => 'max:255',
            'mail_reply_to_email' => 'required|max:255',
            'mail_send_datetime' => 'required',
            'mail_subject' => 'required|max:255',
            'mail_body' => 'required|max:1000',
            'mail_send_file_path' => 'nullable|file|max:524288000'
        ];
    }
}
