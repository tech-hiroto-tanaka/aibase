<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\InitPassChange;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;

class PasswordResetController extends BaseController
{
    private $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function show($token)
    {
        if (!$this->user->getUserByToken($token)) {
            abort(404);
        }
        return view('user.passwordReset.show', [
            'title' => 'パスワード再設定',
            'token' => $token,
        ]);
    }

    public function update(InitPassChange $request, $id)
    {
        if ($this->user->updatePasswordByToken($request, $id)) {
            $this->setFlash(__('パスワード変更が完了しました'));
            return redirect()->route('login.index');
        }
        abort(404);
    }
}
