<?php

namespace App\Http\Controllers\System;

use App\Repositories\Admin\AdminInterface;
use App\Http\Controllers\BaseController;
use App\Enums\RoleType;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends BaseController
{
    private $user;
    public function __construct(AdminInterface $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('system')->check()) {
            return redirect(route('system.dashboard.index'));
        }
        return view('system.login.index', [
            'title' => '管理サイトログイン',
            'message' => $request->message,
            'request' => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('system')->attempt($credentials, $request->remember_me ?? false)) {
            if (!$this->user->updateLastLogin(Auth::guard('system')->user()->id)) {
                Auth::guard('system')->logout();
                return redirect(route('system.login.index'));
            }
            return redirect($request->url_redirect ? $request->url_redirect : route('system.dashboard.index'));
        }
        return redirect(route('system.login.index', ['message' => 'メールアドレスとパスワードが一致しません。']));
    }

    public function logout()
    {
        Auth::guard('system')->logout();
        return redirect(route('system.login.index'));
    }
}
