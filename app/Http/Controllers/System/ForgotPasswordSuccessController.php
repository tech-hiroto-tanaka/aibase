<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ForgotPasswordSuccessController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forgotPasswordSuccess.index', [
            'title' => 'パスワード再発行申請完了',
            'loginUrl' => route('system.login.index')
        ]);
    }
}
