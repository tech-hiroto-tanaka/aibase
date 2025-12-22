<?php

namespace App\Http\Controllers\User;

use App\Enums\RoleType;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Repositories\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LoginController extends BaseController
{
    private $user;
    public function __construct(UserInterface $user)
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
        if (Auth::guard('user')->check()) {
            return redirect(route('top.index'));
        }
        return view('user.login.index', [
            'title' => 'ログイン',
            'message' => $request->message,
            'request' => $request->all(),
            'email' => Session::get('dataEmail') ?? '',
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
     * @param LoginRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('user')->attempt($credentials)) {
            if (!$this->user->updateLastLogin(Auth::guard('user')->user()->id)) {
                Auth::guard('user')->logout();
                return redirect(route('top.index'));
            }
            return redirect($request->url_redirect ? $request->url_redirect : route('top.index'));
        }
        return redirect(route('login.index', ['message' => 'メールアドレスとパスワードが一致しません']))->with(['dataEmail' => $request->email]);
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect(route('login.index'));
    }
}
