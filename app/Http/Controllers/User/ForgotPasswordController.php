<?php

namespace App\Http\Controllers\User;

use App\Enums\RoleType;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ForgotPassword as ForgotPasswordRequest;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends BaseController
{
    private $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $email = Session::get('email') ?? '';
        return view('user.forgotPassword.index', [
            'title' => '【ATSUMARE】パスワードリセット',
            'email' => $email
        ]);
    }

    public function store(ForgotPasswordRequest $request)
    {
        if (!$this->user->getByEmail($request)) {
            $this->setFlash(__('メールアドレスが存在しません。'), 'error');
            return redirect(route('user.forgot-password.index'))->with( ['email' => $request->email]);
        }
        if (!$this->user->generalResetPass($request, RoleType::USER)) {
            $this->setFlash(__('メールが一致しません'), 'error');
            return redirect(route('user.forgot-password.index'));
        }
        return redirect(route('user.forgot-password-complete.index'));
    }

}
