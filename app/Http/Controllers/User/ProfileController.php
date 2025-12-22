<?php

namespace App\Http\Controllers\User;

use App\Enums\RoleType;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Repositories\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Repositories\Area\AreaInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProfileController extends BaseController
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
        return view('user.profile.index', [
            'title' => 'マイページ',
            'request' => $request->all(),
            'user' => $this->user->getById(Auth::guard('user')->user()->id),
            'areas' => $this->areas->getAll()->where('id', '!=', 1),
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
    public function store(Request $request)
    {
        //
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
    public function update(UpdateProfileRequest $request, $id)
    {
        if ($this->user->updateProfile($request)) {
            $this->setFlash(__('マイページの編集が完了しました'));
        } else {
            $this->setFlash(__('エラーが発生しました。'), 'error');
        }
        return redirect()->route('user.profile.index');
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
}
