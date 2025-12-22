<?php

namespace App\Http\Requests;

use App\Models\Genre;
use App\Models\Area;
use App\Models\Skill;
use App\Models\DesiredCost;
use App\Models\Feature;
use App\Models\Prefecture;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobValidate extends FormRequest
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
        $id = $this->job;
        return [
            'job_name' => 'required|max:255',
            'job_code' => [
                'required',
                'max:255',
                Rule::unique('jobs')->whereNull('deleted_at')->where(function($q) use ($id) {
                    if ($id) {
                        $q->where('id', '<>', $id);
                    }
                })
            ],
            'job_cost_start' => 'required|max:255',
            'job_cost_end' => 'nullable|max:255',
            'work_content' => 'nullable|max:20000',
            'job_match_skill' => 'nullable|max:20000',
            'job_period' => 'nullable|max:255',
            'genres' => 'nullable|array',
            'areas' => 'nullable|array',
            'skills' => 'nullable|array',
            'desired_costs' => 'nullable|array',
            'features' => 'nullable|array',
            'job_publish_start_date' => 'required',
            'job_publish_end_date' => 'required',
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
        $genreIds = Genre::pluck('id')->toArray();
        $areaIds = Area::pluck('id')->toArray();
        $skillIds = Skill::pluck('id')->toArray();
        $desiredCostIds = DesiredCost::pluck('id')->toArray();
        $featureIds = Feature::pluck('id')->toArray();
        $prefectureIds = Prefecture::pluck('id')->toArray();
        return $validator->after(function ($validator) use ($data, $genreIds, $areaIds, $skillIds, $desiredCostIds, $featureIds, $prefectureIds) {
            if (!preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]$/", $data['job_publish_start_date'])) {
                $validator->errors()->add('job_publish_start_date', "error");
            }
            if (!preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]$/", $data['job_publish_end_date'])) {
                $validator->errors()->add('job_publish_end_date', "error");
            }
            if (Carbon::parse($data['job_publish_start_date']) > Carbon::parse($data['job_publish_end_date'])) {
                $validator->errors()->add('job_publish_start_date', "error");
            }
            if (isset($data['genres'])) {
                foreach ($data['genres'] as $key => $value) {
                    if (!in_array($value, $genreIds)) {
                        $validator->errors()->add('genres', "error");
                    }
                }
            }
            if (isset($data['areas'])) {
                foreach ($data['areas'] as $key => $value) {
                    if (!in_array($value, $areaIds)) {
                        $validator->errors()->add('areas', "error");
                    }
                }
            }
            if (isset($data['skills'])) {
                foreach ($data['skills'] as $key => $value) {
                    if (!in_array($value, $skillIds)) {
                        $validator->errors()->add('skills', "error");
                    }
                }
            }
            if (isset($data['desired_costs'])) {
                foreach ($data['desired_costs'] as $key => $value) {
                    if (!in_array($value, $desiredCostIds)) {
                        $validator->errors()->add('desired_costs', "error");
                    }
                }
            }
            if (isset($data['features'])) {
                foreach ($data['features'] as $key => $value) {
                    if (!in_array($value, $featureIds)) {
                        $validator->errors()->add('features', "error");
                    }
                }
            }
            if (isset($data['prefectures'])) {
                foreach ($data['prefectures'] as $key => $value) {
                    if (!in_array($value, $prefectureIds)) {
                        $validator->errors()->add('prefectures', "error");
                    }
                }
            }
        });
    }
}
