<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsValidate extends FormRequest
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
            'news_title' => 'required|max:255',
            'news_publish_start_datetime' => 'required',
            'news_publish_end_datetime'=>'required',
            'news_content' => 'required|max:20000',
            'news_file' => 'nullable|file'
        ];
    }
}
