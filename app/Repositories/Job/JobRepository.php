<?php

namespace App\Repositories\Job;

use App\Mail\UserRegisterJob;
use App\Enums\Gender;
use App\Enums\DesiredWorkType;
use App\Enums\PublishStatus;
use App\Models\Job;
use App\Models\Skill;
use App\Models\Genre;
use App\Models\Area;
use App\Models\Prefecture;
use App\Models\AreaPrefecture;
use App\Models\Application;
use App\Models\DesiredCost;
use App\Http\Controllers\BaseController;
use App\Repositories\Job\JobInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class JobRepository extends BaseController implements JobInterface
{
    private Job $job;
    private $application;
    public function __construct(Job $job, Application $application)
    {
        $this->job = $job;
        $this->application = $application;
    }

    public function getJobs($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $jobBuilder = $this->job;
        if (isset($request['search_input'])) {
            $jobBuilder = $jobBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('job_code', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('job_name', $request['search_input']));
                // $q->orWhereJsonContains('genres', ['id' => 1]);
                // $q->orWhereJsonContains('genres', ['id' => 111]);
            });
        }

        $jobs = $jobBuilder->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($jobs)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $jobs = $jobBuilder->paginate($newSizeLimit);
        }
        return $jobs;
    }

    public function getById($id)
    {
        return $this->job->where('id', $id)->first();
    }

    public function store($request)
    {
        $job = $this->job;
        $job->job_code = $request->job_code;
        $job->job_name = $request->job_name;
        $job->job_cost_start = $request->job_cost_start;
        $job->job_cost_end = $request->job_cost_end;
        $job->work_content = $request->work_content;
        $job->job_match_skill = $request->job_match_skill;
        $job->job_period = $request->job_period;
        $job->type_of_job = $request->type_of_job;
        $job->office_towns = $request->office_towns;
        $job->genres = $this->convertArrObj($request->genres);
        $job->areas = $this->convertArrObj($request->areas);
        $job->skills = $this->convertArrObj($request->skills);
        $job->desired_costs = $this->convertArrObj($request->desired_costs);
        $job->features = $this->convertArrObj($request->features);
        $job->prefectures = $this->convertArrObj($request->prefectures);
        $job->job_publish_start_date = $request->job_publish_start_date;
        $job->job_publish_end_date = $request->job_publish_end_date;
        $minDesired = 0;
        if ($request->desired_costs) {
            $minDesired = DesiredCost::whereIn('id', $request->desired_costs)->min('money');
        }
        $job->min_desired_costs = $minDesired;
        $job->job_publish_status = $request->job_publish_status ? PublishStatus::PUBLISH : PublishStatus::UNPUBLISH;
        return $job->save();
    }
    public function convertArrObj($arr)
    {
        $dataConvert = [];
        if (!$arr) {
            return $dataConvert;
        }
        foreach ($arr as $key => $value) {
            $dataConvert[] = [
                'id' => $value
            ];
        }
        return $dataConvert;
    }

    public function update($request, $id)
    {
        $job = $this->job->where('id', $id)->first();
        if (!$job) {
            return false;
        }
        $job->job_code = $request->job_code;
        $job->job_name = $request->job_name;
        $job->job_cost_start = $request->job_cost_start;
        $job->job_cost_end = $request->job_cost_end;
        $job->work_content = $request->work_content;
        $job->job_match_skill = $request->job_match_skill;
        $job->job_period = $request->job_period;
        $job->type_of_job = $request->type_of_job;
        $job->office_towns = $request->office_towns;
        $job->genres = $this->convertArrObj($request->genres);
        $job->areas = $this->convertArrObj($request->areas);
        $job->skills = $this->convertArrObj($request->skills);
        $job->desired_costs = $this->convertArrObj($request->desired_costs);
        $job->features = $this->convertArrObj($request->features);
        $job->prefectures = $this->convertArrObj($request->prefectures);
        $minDesired = 0;
        if ($request->desired_costs) {
            $minDesired = DesiredCost::whereIn('id', $request->desired_costs)->min('money');
        }
        $job->min_desired_costs = $minDesired;
        $job->job_publish_start_date = $request->job_publish_start_date;
        $job->job_publish_end_date = $request->job_publish_end_date;
        $job->job_publish_status = $request->job_publish_status ? PublishStatus::PUBLISH : PublishStatus::UNPUBLISH;
        return $job->save();
    }

    public function destroy($id)
    {
        $job = $this->job->where('id', $id)->first();
        if (!$job) {
            return false;
        }
        return $job->delete();
    }

    public function checkCode($request)
    {
        return !$this->job->where(function ($query) use ($request) {
            if (isset($request['id']) && $request['id']) {
                $query->where('id', '!=', $request["id"]);
            }
            $query->where(['job_code' => $request["value"]]);
        })->exists();
    }

    public function getJobNew($limit = 10)
    {
        return $this->job->with([
            'favorite' => function($q) {
                $q->where('user_id', Auth::guard('user')->check() ? Auth::guard('user')->user()->id : 0);
            }
        ])->where([
            ['job_publish_status', PublishStatus::PUBLISH],
            ['job_publish_start_date', '<', Carbon::now()],
            ['job_publish_end_date', '>', Carbon::now()],
        ])->orderBy('job_publish_start_date')->limit($limit)->get();
    }
    public function searchJob($request, $limit = 6)
    {
        $jobBuilder = $this->job->with([
            'favorite' => function($q) {
                $q->where('user_id', Auth::guard('user')->check() ? Auth::guard('user')->user()->id : 0);
            }
        ]);
        if (isset($request['search_input']) && $request['search_input'] != '') {
            // $skillIds = Skill::where($this->escapeLikeSentence('skill_name', $request['search_input']))->pluck('id');
            // $genreIds = Genre::where($this->escapeLikeSentence('genre_name', $request['search_input']))->pluck('id');
            // $areaIds = Area::where($this->escapeLikeSentence('area_name', $request['search_input']))->pluck('id');
            // $prefectureIds = Prefecture::where($this->escapeLikeSentence('prefecture_name', $request['search_input']))->pluck('id');
            $jobBuilder = $jobBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('job_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('job_cost_start', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('job_cost_end', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('work_content', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('job_match_skill', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('job_period', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence(DB::raw('CASE type_of_job WHEN 1 THEN "派遣" ELSE "共同受注" END'), $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('office_towns', $request['search_input']));

                // foreach ($skillIds as $value) {
                //     $q->orWhereJsonContains('skills', ['id' => (string)$value]);
                // }
                // foreach ($genreIds as $value) {
                //     $q->orWhereJsonContains('genres', ['id' => (string)$value]);
                // }
                // foreach ($areaIds as $value) {
                //     $q->orWhereJsonContains('areas', ['id' => (string)$value]);
                // }
                // foreach ($prefectureIds as $value) {
                //     $q->orWhereJsonContains('prefectures', ['id' => (string)$value]);
                // }
            });
        }
        if (isset($request['genres']) && $request['genres'] != '') {
            $jobBuilder = $jobBuilder->where(function($q) use ($request) {
                foreach ($request['genres'] as $key => $value) {
                    if (!$value) {
                        continue;
                    }
                    $q->orWhereJsonContains('genres', ['id' => $value]);
                }
            });
        }
        // $areaPrefectureIds = [];
        // if (isset($request['areas']) && $request['areas'] != '') {
        //     $jobBuilder = $jobBuilder->where(function($q) use ($request) {
        //         foreach ($request['areas'] as $key => $value) {
        //             if (!$value) {
        //                 continue;
        //             }
        //             $q->orWhereJsonContains('areas', ['id' => $value]);
        //         }
        //     });
        //     $areaIds = [];
        //     foreach ($request['areas'] as $value) {
        //         if (!$value) continue;
        //         $areaIds[] = $value;
        //     }

        //     $prefectureIdStrings = [];
        //     foreach (Prefecture::whereIn('area_id', $areaIds)->pluck('id')->toArray() as $prefectureIdInt) {
        //         $prefectureIdStrings[] = (string) $prefectureIdInt;
        //     }
        //     $areaPrefectureIds = $prefectureIdStrings;
        // }

        // $searchPrefecture = true;
        // $allPrefectureIds = [];
        // $isPrefectures = isset($request['prefectures']) && $request['prefectures'] != '';
        // if (!empty($areaPrefectureIds)) {
        //     if ($isPrefectures) {
        //         $allPrefectureIds = array_merge($request['prefectures'],$areaPrefectureIds);
        //         $allPrefectureIds = array_values(array_unique($allPrefectureIds));
        //     } else {
        //         $allPrefectureIds = $areaPrefectureIds;
        //     }
        // } else {
        //     if ($isPrefectures) {
        //         $allPrefectureIds = $request['prefectures'];
        //     } else {
        //         $searchPrefecture = false;
        //     }
        // }
        $allPrefectureIds = [];
        if (isset($request['prefectures']) && $request['prefectures'] != '') {
            $allPrefectureIds = $request['prefectures'];
        }
        if (isset($request['areas']) && $request['areas'] != '' && !isset($request['prefectures'])) {
            $allPrefectureIds = AreaPrefecture::where('area_id', $request['areas'][0])->pluck('prefecture_id');
        }
        if ($allPrefectureIds) {
            $jobBuilder = $jobBuilder->where(function($q) use ($allPrefectureIds) {
                foreach ($allPrefectureIds as $key => $value) {
                    if (!$value) {
                        continue;
                    }
                    $q->orWhereJsonContains('prefectures', ['id' => $value]);
                }
            });
        }

        if (isset($request['skills']) && $request['skills'] != '') {
            $jobBuilder = $jobBuilder->where(function($q) use ($request) {
                foreach ($request['skills'] as $key => $value) {
                    if (!$value) {
                        continue;
                    }
                    $q->orWhereJsonContains('skills', ['id' => $value]);
                }
            });
        }
        if (isset($request['desiredCosts']) && $request['desiredCosts'] != '') {
            $jobBuilder = $jobBuilder->where(function($q) use ($request) {
                foreach ($request['desiredCosts'] as $key => $value) {
                    if (!$value) {
                        continue;
                    }
                    $q->orWhereJsonContains('desired_costs', ['id' => $value]);
                }
            });
        }
        if (isset($request['features']) && $request['features'] != '') {
            $jobBuilder = $jobBuilder->where(function($q) use ($request) {
                foreach ($request['features'] as $key => $value) {
                    if (!$value) {
                        continue;
                    }
                    $q->orWhereJsonContains('features', ['id' => $value]);
                }
            });
        }
        if (isset($request['typeOfJobs']) && $request['typeOfJobs']) {
            $jobBuilder = $jobBuilder->whereIn('type_of_job', $request['typeOfJobs']);
        }
        $jobBuilder = $jobBuilder->where([
            ['job_publish_status', PublishStatus::PUBLISH],
            ['job_publish_start_date', '<', Carbon::now()],
            ['job_publish_end_date', '>', Carbon::now()],
        ]);
        // $jobs = $jobBuilder->sortable($this->sortLogic())->paginate($limit);
        $jobs = $jobBuilder->sortable(['updated_at' => 'desc'])->paginate($limit);
        if ($this->checkPaginatorList($jobs)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $jobs = $jobBuilder->paginate($limit);
        }
        return $jobs;
    }

    public function sortLogic()
    {
        $sorts = [];
        $searchData = session()->get('searchData');
        if ( $searchData !== null ) {
            foreach( $searchData  as $sort){
                if (!isset($sort['sort'])) break;
                $sorts[$sort['sort']] = $sort['direction'];
            }
        }
        return $sorts ?? [];
    }

    public function jobPublic($request)
    {
        return $this->job->where([
            ['job_publish_status', PublishStatus::PUBLISH],
            ['job_publish_start_date', '<', Carbon::now()],
            ['job_publish_end_date', '>', Carbon::now()],
            ['id', $request->job_id],
        ])->first();
    }
    public function getJobFavorites($request)
    {
        // $newSizeLimit = $this->newListLimit($request);
        $newSizeLimit = 6;
        $jobBuilder = $this->job->with([
            'favorite' => function($q) {
                $q->where('user_id', Auth::guard('user')->user()->id);
            }
        ])->join('favorites', 'jobs.id', '=', 'favorites.job_id')
        ->whereNull('favorites.deleted_at')
        ->where('favorites.user_id', Auth::guard('user')->user()->id);
        $jobBuilder = $jobBuilder->where([
            ['job_publish_status', PublishStatus::PUBLISH],
            ['job_publish_start_date', '<', Carbon::now()],
            ['job_publish_end_date', '>', Carbon::now()],
        ]);
        $jobs = $jobBuilder->select(['jobs.*', 'favorites.id as favorites_id', 'favorites.user_id'])->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($jobs)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $jobs = $jobBuilder->paginate($newSizeLimit);
        }
        return $jobs;
    }
    public function getJobViewHistories($request)
    {
        // $newSizeLimit = $this->newListLimit($request);
        $newSizeLimit = 6;
        $jobBuilder = $this->job->with([
            'favorite' => function($q) {
                $q->where('user_id', Auth::guard('user')->user()->id);
            }
        ])->join('user_view_histories', 'jobs.id', '=', 'user_view_histories.job_id')
        ->whereNull('user_view_histories.deleted_at')
        ->where('user_view_histories.user_id', Auth::guard('user')->user()->id);
        $jobBuilder = $jobBuilder->where([
            ['job_publish_status', PublishStatus::PUBLISH],
            ['job_publish_start_date', '<', Carbon::now()],
            ['job_publish_end_date', '>', Carbon::now()],
        ]);
        $jobs = $jobBuilder->select(['jobs.*', 'user_view_histories.id as user_view_histories_id', 'user_view_histories.user_id'])->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($jobs)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $jobs = $jobBuilder->paginate($newSizeLimit);
        }
        return $jobs;
    }

    public function jobPublicById($id)
    {
        return $this->job->with([
            'favorite' => function($q) {
                if (Auth::guard('user')->check()) {
                    $q->where('user_id', Auth::guard('user')->user()->id);
                }
            }
        ])->where([
            ['job_publish_status', PublishStatus::PUBLISH],
            ['job_publish_start_date', '<', Carbon::now()],
            ['job_publish_end_date', '>', Carbon::now()],
            ['id', $id],
        ])->first();
    }
    public function userRegisterApp($id)
    {
        // $app = $this->application->where([
        //     ['user_id', Auth::guard('user')->user()->id],
        //     ['job_id', $id]
        // ])->first();
        // if (!$app) {
            $app = new $this->application;
            $app->user_id = Auth::guard('user')->user()->id;
            $app->job_id = $id;
        // }
        // $app->updated_at = Carbon::now();
        if (!$app->save()) {
            return false;
        }
        $userInfo = Auth::guard('user')->user();
        $mailContents = [
            'area_name' => $userInfo->area ? $userInfo->area->area_name : '',
            'hira_first_name' => $userInfo->hira_first_name,
            'hira_last_name' => $userInfo->hira_last_name,
            'kata_first_name' => $userInfo->kata_first_name,
            'kata_last_name' => $userInfo->kata_last_name,
            'email' => $userInfo->email,
            'birthday' => $userInfo->birthday_date_format,
            'gender' => Gender::getDescription($userInfo->gender),
            'phone_number' => $userInfo->phone_number,
            'desired_work' => DesiredWorkType::getDescription($userInfo->desired_work_type),
            'experience_skills_from_date' => $userInfo->experience_skills_from_date_format,
            'experience_skills_detail' => $userInfo->experience_skills_detail,
            'nearest_station_name' => $userInfo->nearest_station_name,
            'other_requests' => $userInfo->other_requests,
        ];
        Mail::to($userInfo->email)->send(new UserRegisterJob($mailContents));
        return true;
    }

    public function getJobSuggest($job)
    {
        $jobBuilder = $this->job->with([
            'favorite' => function($q) {
                $q->where('user_id', Auth::guard('user')->check() ? Auth::guard('user')->user()->id : 0);
            }
        ])->where('id', '!=', $job->id);
        return $jobBuilder->where(function($q) use ($job) {
            if ($job->areas) {
                foreach ($job->areas as $key => $value) {
                    if (!$value) {
                        continue;
                    }
                    $q->orWhereJsonContains('areas', ['id' => $value['id']]);
                }
            }
            if ($job->skills) {
                foreach ($job->skills as $key => $value) {
                    if (!$value) {
                        continue;
                    }
                    $q->orWhereJsonContains('skills', ['id' => $value['id']]);
                }
            }
        })->where([
            ['job_publish_status', PublishStatus::PUBLISH],
            ['job_publish_start_date', '<', Carbon::now()],
            ['job_publish_end_date', '>', Carbon::now()],
        ])->get();
    }
}
