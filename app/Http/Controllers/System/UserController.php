<?php

namespace App\Http\Controllers\System;

use App\Enums\Gender;
use App\Http\Requests\System\CreateUserRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserInterface;
use App\Http\Controllers\BaseController;
use App\Enums\StatusCode;
use App\Repositories\Area\AreaInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class UserController extends BaseController
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
        $breadcrumbs = [
            'ユーザー一覧',
        ];
        $newSizeLimit = $this->newListLimit($request);
        $userList = $this->user->getUsers($request);
        session()->forget('data.users');
        session()->push('data.users', $userList->items());
        return view('system.user.index', [
            'title' => 'ユーザー一覧',
            'breadcrumbs' => $breadcrumbs,
            'users' => $userList,
            'request' => $request,
            'newSizeLimit' => $newSizeLimit,
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
        $breadcrumbs = [
            [
                'url' => route('system.user.index'),
                'name' => 'ユーザー一覧',
            ],
            'ユーザー登録'
        ];
        return view('system.user.create', [
            'title' => 'ユーザー登録',
            'breadcrumbs' => $breadcrumbs,
            'areas' => $this->areas->getAll(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        if ($this->user->store($request)) {
            $this->setFlash(__('ユーザーの新規作成が完了しました。'));
            return redirect(route('system.user.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.user.create');
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
        $breadcrumbs = [
            [
                'url' => route('system.user.index'),
                'name' => 'ユーザー一覧',
            ],
            'ユーザー編集'
        ];
        $user = $this->user->getById($id);
        if (!$user) {
            return redirect(route('system.user.index'));
        }
        return view('system.user.edit', [
            'title' => 'ユーザー編集',
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'areas' => $this->areas->getAll(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if ($this->user->update($request, $id)) {
            $this->setFlash(__('ユーザーの編集が完了しました。'));
            return redirect(route('system.user.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.user.update', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->user->destroy($id)) {
            return response()->json([
                'message' => 'ユーザーの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }

    public function checkEmail(Request $request)
    {
        return response()->json([
            'valid' => $this->user->checkEmail($request),
        ], StatusCode::OK);
    }

    public function export(Request $request)
    {
        $fileName = "member_" . Carbon::now()->format("YmdHis") . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $header = [
            chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF')) . '氏名',
            '氏名（カタ）',
            'メールアドレス',
            '性別',
            'お住まいのエリア',
            '登録日時'
        ];

        if (!file_exists(public_path() . '/csv_file/user')) {
            mkdir(public_path() . '/csv_file/user', 0777, true);
        }
        $localPath = public_path() . '/csv_file/user/' . $fileName;
        $file = fopen($localPath, 'w');
        fputcsv($file, $header);

        $list = session()->get('data.users')[0] ?? [];
        foreach ($list as $key => $item) {
            $input = [];
            $input['name'] = chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF')). $item->hira_first_name . '　' . $item->hira_last_name;
            $input['name_kata'] = $item->kata_first_name . '　' . $item->kata_last_name;
            $input['email'] = $item->email;
            $input['gender'] = Gender::getDescription($item->gender);
            $input['area_name'] = $item->area ? $item->area->area_name : '';
            $input['created_at'] = Carbon::parse($item->created_at)->format('Y/m/d H:i:s');
            fputcsv($file, $input);
        }

        return Response::download(public_path() . '/csv_file/user/' . $fileName, $fileName, $header);
    }
}
