<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordCompleteController extends BaseController
{
    public function index()
    {
        return view('user.forgotPasswordComplete.index', [
            'title' => '【ATSUMARE】パスワード変更完了のお知らせ',
            'loginUrl' => route('login.index')
        ]);
    }
}
