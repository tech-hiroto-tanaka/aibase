<?php

namespace App\Repositories\JobContact;

use App\Http\Controllers\BaseController;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use App\Repositories\JobContact\JobContactInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class JobContactRepository extends BaseController implements JobContactInterface
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function getJobContact($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $jobBuilder =  $this->app
            ->join('users', 'users.id', '=', 'applications.user_id')
            ->join('jobs', 'jobs.id', '=', 'applications.job_id')
            ->whereNull(['users.deleted_at', 'jobs.deleted_at'])
            ->select([
                'applications.id',
                'applications.created_at',
                'jobs.job_code as code',
                'jobs.job_name as name',
                'jobs.job_publish_start_date as start_date',
                'jobs.job_publish_end_date as end_date',
                'users.email as email',
                'applications.is_read',
                'applications.status',
            ]);

        if ($request->search_input && $request->search_input != '') {
            $jobContact = $jobBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('email', $request->search_input));
                $q->orWhere($this->escapeLikeSentence('job_name', $request->search_input));
                $q->orWhere($this->escapeLikeSentence('job_code', $request->search_input));
                $q->orWhere($this->escapeLikeSentence(DB::raw('CASE applications.status WHEN 0 THEN "新規 ( 未対応）" WHEN 1 THEN "対応中" WHEN 2 THEN "対応済" ELSE "対応必要無し" END'), $request['search_input']));
            });
        }

        if ($request->job_name && $request->job_name != '') {
            $jobContact = $jobBuilder->where($this->escapeLikeSentence('job_name', $request->job_name));
        }
        if ($request->job_code && $request->job_code != '') {
            $jobContact = $jobBuilder->where($this->escapeLikeSentence('job_code', $request->job_code));
        }
        if ($request->email && $request->email != '') {
            $jobContact = $jobBuilder->where($this->escapeLikeSentence('email', $request->email));
        }

        $jobContact = $jobBuilder->sortable(['created_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($jobContact)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $jobContact = $jobBuilder->paginate($newSizeLimit);
        }
        return $jobContact;
    }

    public function getById($id)
    {
        return $this->app
            ->join('users', 'users.id', '=', 'applications.user_id')
            ->join('jobs', 'jobs.id', '=', 'applications.job_id')
            ->whereNull(['users.deleted_at', 'jobs.deleted_at'])
            ->where('applications.id', $id)
            ->select(
                'applications.id',
                'applications.created_at as created',
                'jobs.job_code as code',
                'jobs.job_name as job_name',
                'jobs.job_cost_start as cost_start',
                'jobs.job_cost_end as cost_end',
                'jobs.job_publish_start_date as start_date',
                'jobs.job_publish_end_date as end_date',
                'jobs.areas as areas',
                'jobs.skills as skills',
                'users.email',
                'applications.status',
            )->first();
    }
    public function destroy($id)
    {
        $jobContact = $this->app->where('id', $id)->first();
        if (!$jobContact) {
            return false;
        }
        return $jobContact->delete();
    }
    public function update($request, $id)
    {
        $contactInfo = $this->app->where('id', $id)->first();
        if (!$contactInfo) {
            return false;
        }
        $contactInfo->status = $request->status ?? 0;
        return $contactInfo->save();
    }
}
