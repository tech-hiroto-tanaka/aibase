<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\CheckExpiredActiveUserTokenRequest;
use App\Repositories\User\UserInterface;
use App\Enums\StatusCode;
use App\Repositories\Area\AreaInterface;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    private $user;
    private $areas;
    public function __construct(UserInterface $user, AreaInterface $areas)
    {
        $this->user = $user;
        $this->areas = $areas;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestData = $request->all();
        if (empty($requestData)) {
            $requestData = $request->old();
        }

        return view('user.register.index', [
            'title' => 'カンタン新規会員登録',
            'message' => $request->message,
            'request' => $requestData,
            'areas' => $this->areas->getAll()->where('id', '!=', 1),
        ]);
    }

    public function done(Request $request)
    {
        return view('user.register.done', [
            'title' => '新規会員登録',
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
    public function store(RegisterRequest $request)
    {
        if ($this->user->register($request)) {
            // $this->setFlash(__('新規会員の登録が完了しました'));
            return redirect(route('register.done'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('register.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function activeUser($token)
    {
        if ($this->user->checkActiveUserToken($token)) {
            // $this->setFlash(__('アカウントは正常にアクティブです'));
            return redirect(route('user.verifySuccess'));
        }
        return abort(404);
    }
    public function verifySuccess()
    {
        return view('user.register.verifySuccess', [
            'title' => '新規会員登録',
        ]);
    }

    public function checkEmail(Request $request)
    {
        if (Auth::guard('user')->check()) {
            $request['id'] = Auth::guard('user')->user()->id;
        }
        return response()->json([
            'valid' => $this->user->checkEmail($request),
        ], StatusCode::OK);
    }
}
