<?php

namespace App\Http\Controllers\System;

use App\Enums\RoleType;
use App\Repositories\User\UserInterface;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ForgotPassword as ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class ForgotPasswordController extends BaseController
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
    public function index()
    {
        return view('system.forgotPassword.index', [
            'title' => 'パスワード再発行申請',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForgotPasswordRequest $request)
    {

        if (!$this->user->getByEmail($request)) {
            $this->setFlash(__('メールでユーザーを見つけることができません'), 'error');
            return redirect(route('system.forgot_password.index'));
        }
        if (!$this->user->generalResetPass($request, RoleType::SYSTEM_ADMIN)) {
            $this->setFlash(__('メールが一致しません'), 'error');
            return redirect(route('system.forgot_password.index'));
        }
        return redirect(route('system.forgot_password_complete.index'));
    }
}
