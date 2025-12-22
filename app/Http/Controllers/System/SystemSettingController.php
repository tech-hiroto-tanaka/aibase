<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SystemSettingValidate;
use App\Models\SystemSetting;
use App\Repositories\SystemSetting\SystemSettingInterface;
use Illuminate\Http\Request;

class SystemSettingController extends BaseController
{
    private SystemSettingInterface $systemSetting;
    public function __construct(SystemSettingInterface $systemSetting)
    {
        $this->systemSetting = $systemSetting;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = ['システム設定'];
        return view('system.system_setting.index', [
            'title' => '新しい設定を送信する',
            'breadcrumbs' => $breadcrumbs,
            'systemSettingInfo' => $this->systemSetting->getSystemSetting(),
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
    public function store(SystemSettingValidate $request)
    {
        if ($this->systemSetting->store($request)) {
            $this->setFlash(__('システム設定の変更が完了しました。'));
            return redirect()->route('system.system-setting.index');
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.system-setting.index');
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
    public function update(SystemSettingValidate $request, $id)
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
}
