<?php

namespace App\Repositories\UserViewHistory;

use App\Models\UserViewHistory;
use App\Models\Job;
use App\Http\Controllers\BaseController;
use App\Repositories\UserViewHistory\UserViewHistoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserViewHistoryRepository extends BaseController implements UserViewHistoryInterface
{
    private UserViewHistory $userViewHistory;
    private Job $job;
    public function __construct(Job $job, UserViewHistory $userViewHistory)
    {
        $this->userViewHistory = $userViewHistory;
        $this->job = $job;
    }

    public function get($request)
    {
        // TODO: Implement get() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function store($id)
    {
        $userViewHistory = $this->userViewHistory->where([
            ['user_id', Auth::guard('user')->user()->id],
            ['job_id', $id]
        ])->first();
        if (!$userViewHistory) {
            $userViewHistory = new $this->userViewHistory;
            $userViewHistory->user_id = Auth::guard('user')->user()->id;
            $userViewHistory->job_id = $id;
        }
        $userViewHistory->updated_at = Carbon::now();
        $job = $this->job->where('id', $id)->first();
        if (!$job) {
            return false;
        }
        $job->view_count++;
        return $userViewHistory->save() && $job->save();;
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
