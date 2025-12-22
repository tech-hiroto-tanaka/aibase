<?php

namespace App\Repositories\User;

use App\Enums\RoleType;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Mail\ForgotPassword;
use App\Mail\ActiveUser;
use App\Mail\VerifySuccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseController implements UserInterface
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $userBuilder = $this->user->with(['area']);
        if (isset($request['search_input']) && $request['search_input'] != '') {
            $userBuilder = $userBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence(DB::raw('CONCAT(hira_first_name, "　", hira_last_name)'), $request['search_input']));
                $q->orWhere($this->escapeLikeSentence(DB::raw('CONCAT(kata_first_name, "　", kata_last_name)'), $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('email', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('other_requests', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('nearest_station_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('experience_skills_detail', $request['search_input']));
            });
        }
        if ($request->mail_condition) {
            $condition = $request->mail_condition;
            if (isset($condition['name']) && $condition['name'] != '') {
                $userBuilder = $userBuilder->where($this->escapeLikeSentence(DB::raw('CONCAT(hira_first_name, "　", hira_last_name)'), $condition['name']));
            }
            if (isset($condition['name_furigana']) && $condition['name_furigana'] != '') {
                $userBuilder = $userBuilder->where($this->escapeLikeSentence(DB::raw('CONCAT(kata_first_name, "　", kata_last_name)'), $condition['name_furigana']));
            }
            if (isset($condition['gender']) && $condition['gender']) {
                $userBuilder = $userBuilder->where(function ($q) use ($condition) {
                    $q->whereIn('gender', $condition['gender']);
                });
            }
            if (isset($condition['birthday']) && $condition['birthday'] != '') {
                $userBuilder = $userBuilder->whereDate('birthday', $condition['birthday']);
            }
            if (isset($condition['email']) && $condition['email'] != '') {
                $userBuilder = $userBuilder->where($this->escapeLikeSentence('email', $condition['email']));
            }
            if (isset($condition['phone_number']) && $condition['phone_number'] != '') {
                $userBuilder = $userBuilder->where($this->escapeLikeSentence('phone_number', $condition['phone_number']));
            }
            if (isset($condition['area']) && $condition['area'] != '') {
                $userBuilder = $userBuilder->whereIn('area_id', $condition['area']);
            }
            if (isset($condition['desired_work_type']) && $condition['desired_work_type'] != '') {
                $userBuilder = $userBuilder->whereIn('desired_work_type', $condition['desired_work_type']);
            }
            if (isset($condition['experience_skills_detail']) && $condition['experience_skills_detail'] != '') {
                $userBuilder = $userBuilder->where($this->escapeLikeSentence('experience_skills_detail', $condition['experience_skills_detail']));
            }
            if (isset($condition['nearest_station_name']) && $condition['nearest_station_name'] != '') {
                $userBuilder = $userBuilder->where($this->escapeLikeSentence('nearest_station_name', $condition['nearest_station_name']));
            }
            if (isset($condition['other_requests']) && $condition['other_requests'] != '') {
                $userBuilder = $userBuilder->where($this->escapeLikeSentence('other_requests', $condition['other_requests']));
            }
        }
        $users = $userBuilder->sortable(['created_at' => 'desc', 'status' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($users)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $users = $userBuilder->paginate($newSizeLimit);
        }
        return $users;
    }

    public function destroy($id)
    {
        $userInfo = $this->user->where('id', $id)->first();
        if (!$userInfo) {
            return false;
        }
        return $userInfo->delete();
    }
    public function checkEmail($request)
    {
        return !$this->user->where(function ($query) use ($request) {
            if (isset($request['id'])) {
                $query->where('id', '!=', $request["id"]);
            }
            $query->whereNotNull('email_verified_at');
            $query->where('email', $request["value"]);
        })->exists();
    }
    public function store($request)
    {
        $this->user->hira_first_name = $request->hira_first_name;
        $this->user->hira_last_name = $request->hira_last_name;
        $this->user->kata_first_name = $request->kata_first_name;
        $this->user->kata_last_name = $request->kata_last_name;
        $this->user->password = Hash::make($request->password);
        $this->user->email = $request->email;
        $this->user->birthday = $request->birthday;
        $this->user->gender = $request->gender;
        $this->user->phone_number = $request->phone_number;
        $this->user->area_id = $request->area_id;
        $this->user->desired_work_type = $request->desired_work_type;
        $this->user->experience_skills_from_date = $request->experience_skills_from_date;
        $this->user->experience_skills_detail = $request->experience_skills_detail;
        $this->user->nearest_station_name = $request->nearest_station_name;
        $this->user->other_requests = $request->other_requests;
        // $this->user->email_verified_at = now();
        $this->user->email_verified_token = md5($request->email . random_bytes(25) . Carbon::now());
        $this->user->email_verified_token_expire = Carbon::now()->addMinutes(env('EXPIRE_TOKEN_VERIFY', 1440));
        if (!$this->user->save()) {
            return false;
        }

        $mailContents = [
            'email' => $request->email,
            'link' => route('user.active', $this->user->email_verified_token)
        ];
        Mail::to($request->email)->send(new ActiveUser($mailContents));
        return true;
    }
    public function getById($id)
    {
        return $this->user->where('id', $id)->first();
    }
    public function update($request, $id)
    {
        $userInfo = $this->user->where('id', $id)->first();
        if (!$userInfo) {
            return false;
        }

        $userInfo->hira_first_name = $request->hira_first_name;
        $userInfo->hira_last_name = $request->hira_last_name;
        $userInfo->kata_first_name = $request->kata_first_name;
        $userInfo->kata_last_name = $request->kata_last_name;
        $userInfo->birthday = $request->birthday;
        $userInfo->experience_skills_from_date = $request->experience_skills_from_date;
        $userInfo->gender = $request->gender;
        $userInfo->email = $request->email;
        $userInfo->phone_number = $request->phone_number;
        $userInfo->desired_work_type = $request->desired_work_type;
        $userInfo->experience_skills_detail = $request->experience_skills_detail;
        $userInfo->nearest_station_name = $request->nearest_station_name;
        $userInfo->other_requests = $request->other_requests;
        $userInfo->area_id = $request->area_id;
        if ($request->password) {
            $userInfo->password = Hash::make($request->password);
        }
        return $userInfo->save();
    }

    public function updateLastLogin($id)
    {
        $currentUser = $this->user->where('id', $id)->first();
        if (!$currentUser) {
            return false;
        }
        $currentUser->last_login_at = Carbon::now();
        return $currentUser->save();
    }
    public function getByEmail($request)
    {
        $userInfo = $this->user->where('email', $request->email)->first();
        if (!$userInfo || !$userInfo->email_verified_at) {
            return false;
        }
        return $userInfo;
    }
    public function generalResetPass($request, $userType)
    {
        $account = $this->user->where('email', $request->email)->first();
        if (!$account) {
            return false;
        }
        $account->reset_password_token = md5($request->email . random_bytes(25) . Carbon::now());
        $account->reset_password_token_expire = Carbon::now()->addMinutes(env('EXPIRE_TOKEN_FORGOT_PASSWORD', 30));
        if (!$account->save()) {
            return false;
        }
        $link = '';
        if ($userType === RoleType::SYSTEM_ADMIN) {
            $link = route('system.password_reset.show', $account->reset_password_token);
        } else if ($userType === RoleType::USER) {
            $link = route('user.password-reset.show', $account->reset_password_token);
        }
        $mailContents = [
            'data' => [
                'name' => $account->hira_first_name . ' ' . $account->hira_last_name,
                'link' => $link
            ]
        ];
        Mail::to($account->email)->send(new ForgotPassword($mailContents));
        return true;
    }

    public function register($request)
    {
        $account = $this->user->where('email', $request->email)->whereNull('email_verified_at')->first();
        if (!$account) {
            $account = new $this->user;
        }
        $account->email_verified_token = md5($request->email . random_bytes(25) . Carbon::now());
        $account->email_verified_token_expire = Carbon::now()->addMinutes(env('EXPIRE_TOKEN_VERIFY', 1440));
        $account->hira_first_name = $request->hira_first_name;
        $account->hira_last_name = $request->hira_last_name;
        $account->kata_first_name = $request->kata_first_name;
        $account->kata_last_name = $request->kata_last_name;
        $account->birthday = $request->birthday;
        $account->experience_skills_from_date = $request->experience_skills_from_date;
        $account->gender = $request->gender;
        $account->email = $request->email;
        $account->phone_number = $request->phone_number;
        $account->desired_work_type = $request->desired_work_type;
        $account->experience_skills_detail = $request->experience_skills_detail;
        $account->nearest_station_name = $request->nearest_station_name;
        $account->other_requests = $request->other_requests;
        $account->password = Hash::make($request->password);
        $account->area_id = $request->area_id;
        if (!$account->save()) {
            return false;
        }

        $mailContents = [
            'email' => $request->email,
            'link' => route('user.active', $account->email_verified_token)
        ];
        Mail::to($request->email)->send(new ActiveUser($mailContents));
        return true;
    }

    public function getUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function checkActiveUserToken($token)
    {
        $userInfo =  $this->user->where([
            ['email_verified_token', $token],
            ['email_verified_token_expire', '>=', Carbon::now()]
        ])->first();
        if (!$userInfo) {
            return false;
        }
        $userInfo->email_verified_at = Carbon::now();
        $userInfo->email_verified_token = null;
        $userInfo->email_verified_token_expire = null;
        if (!$userInfo->save()) {
            return false;
        }
        $mailContents = [
            'urlProfile' => route('user.profile.index'),
            'urlPolicy' => route('privacy.index'),
        ];
        Mail::to($userInfo->email)->send(new VerifySuccess($mailContents));
        return true;
    }

    public function getUserByToken($token)
    {
        return $this->user->where([
            ['reset_password_token', $token],
            ['reset_password_token_expire', '>=', Carbon::now()]
        ])->first();
    }
    public function updatePasswordByToken($request, $token)
    {
        $account = $this->getUserByToken($token);
        if (!$account) {
            return false;
        }
        $account->password = Hash::make($request->password);
        $account->reset_password_token = null;
        if (!$account->save()) {
            return false;
        }
        $mailContents = [
            'name' => $account->hira_first_name . ' ' . $account->hira_last_name,
            'mail' => $account->email,
        ];
        return true;
    }

    public function updateProfile($request)
    {
        $userInfo = $this->user->where('id', Auth::guard('user')->user()->id)->first();
        if (!$userInfo) {
            return false;
        }
        $userInfo->hira_first_name = $request->hira_first_name;
        $userInfo->hira_last_name = $request->hira_last_name;
        $userInfo->kata_first_name = $request->kata_first_name;
        $userInfo->kata_last_name = $request->kata_last_name;
        $userInfo->birthday = $request->birthday;
        $userInfo->experience_skills_from_date = $request->experience_skills_from_date;
        $userInfo->gender = $request->gender;
        $userInfo->email = $request->email;
        $userInfo->phone_number = $request->phone_number;
        $userInfo->area_id = $request->area_id;
        $userInfo->desired_work_type = $request->desired_work_type;
        $userInfo->experience_skills_detail = $request->experience_skills_detail;
        $userInfo->nearest_station_name = $request->nearest_station_name;
        $userInfo->other_requests = $request->other_requests;
        if ($request->password) {
            $userInfo->password = Hash::make($request->password);
        }
        return $userInfo->save();
    }
    public function getUserSendMail($condition)
    {
        $userBuilder = $this->user->with('area');
        if (isset($condition['name']) && $condition['name'] != '') {
            $userBuilder = $userBuilder->where($this->escapeLikeSentence(DB::raw('CONCAT(hira_first_name, "　", hira_last_name)'), $condition['name']));
        }
        if (isset($condition['name_furigana']) && $condition['name_furigana'] != '') {
            $userBuilder = $userBuilder->where($this->escapeLikeSentence(DB::raw('CONCAT(kata_first_name, "　", kata_last_name)'), $condition['name_furigana']));
        }
        if (isset($condition['gender']) && $condition['gender']) {
            $userBuilder = $userBuilder->where(function ($q) use ($condition) {
                $q->whereIn('gender', $condition['gender']);
            });
        }
        if (isset($condition['birthday']) && $condition['birthday'] != '') {
            $userBuilder = $userBuilder->whereDate('birthday', $condition['birthday']);
        }
        if (isset($condition['email']) && $condition['email'] != '') {
            $userBuilder = $userBuilder->where($this->escapeLikeSentence('email', $condition['email']));
        }
        if (isset($condition['phone_number']) && $condition['phone_number'] != '') {
            $userBuilder = $userBuilder->where($this->escapeLikeSentence('phone_number', $condition['phone_number']));
        }
        if (isset($condition['area']) && $condition['area'] != '') {
            $userBuilder = $userBuilder->whereIn('area_id', $condition['area']);
        }
        if (isset($condition['desired_work_type']) && $condition['desired_work_type'] != '') {
            $userBuilder = $userBuilder->whereIn('desired_work_type', $condition['desired_work_type']);
        }
        if (isset($condition['experience_skills_detail']) && $condition['experience_skills_detail'] != '') {
            $userBuilder = $userBuilder->where($this->escapeLikeSentence('experience_skills_detail', $condition['experience_skills_detail']));
        }
        if (isset($condition['nearest_station_name']) && $condition['nearest_station_name'] != '') {
            $userBuilder = $userBuilder->where($this->escapeLikeSentence('nearest_station_name', $condition['nearest_station_name']));
        }
        if (isset($condition['other_requests']) && $condition['other_requests'] != '') {
            $userBuilder = $userBuilder->where($this->escapeLikeSentence('other_requests', $condition['other_requests']));
        }
        return $userBuilder->get();
    }
}
