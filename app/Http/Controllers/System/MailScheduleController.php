<?php

namespace App\Http\Controllers\System;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Requests\MailScheduleRequest;
use App\Repositories\Area\AreaInterface;
use App\Repositories\MailMaster\MailMasterInterface;
use App\Repositories\MailSchedule\MailScheduleInterface;
use App\Repositories\MailTemplate\MailTemplateInterface;
use Illuminate\Http\Request;

class MailScheduleController extends BaseController
{
    private MailScheduleInterface $mailSchedule;
    private MailTemplateInterface $mailTemplate;
    private MailMasterInterface $mailMaster;
    private AreaInterface $area;


    public function __construct(
        MailScheduleInterface $mailSchedule,
        MailTemplateInterface $mailTemplate,
        MailMasterInterface $mailMaster,
        AreaInterface $area
    ) {
        $this->mailSchedule = $mailSchedule;
        $this->mailTemplate = $mailTemplate;
        $this->mailMaster = $mailMaster;
        $this->area = $area;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('system.mailSchedule.index', [
            'title' => ' メール配信管理',
            'breadcrumbs' => [' メール配信管理'],
            'newSizeLimit' => $this->newListLimit($request),
            'schedules' => $this->mailSchedule->get($request),
            'request' => $request
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('system.mailSchedule.create', [
            'title' => '新規メール作成',
            'breadcrumbs' => [
                ['url' => route('system.mail-schedule.index'), 'name' => 'メール配信管理'],
                '新規メール作成'
            ],
            'templates' => $this->mailTemplate->getAll(),
            'mailMasters' => $this->mailMaster->get(),
            'areas' => $this->area->getAll()->where('id', '!=', 1),
            'request' => $request
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MailScheduleRequest $request)
    {
        if ($this->mailSchedule->store($request)) {
            $this->setFlash(__('メールの新規作成が完了しました。'));
            return redirect(route('system.mail-schedule.index'));
        }

        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.mail-schedule.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $item = $this->mailSchedule->getById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = $this->mailSchedule->getById($id);
        if (!$schedule) {
            return redirect(route('system.mail-schedule.index'));
        }
        return view('system.mailSchedule.edit', [
            'title' => 'メール編集',
            'breadcrumbs' => [
                ['url' => route('system.mail-schedule.index'), 'name' => 'メール一覧'],
                'メール編集'
            ],
            'templates' => $this->mailTemplate->getAll(),
            'schedule' => $schedule,
            'mailMasters' => $this->mailMaster->get(),
            'areas' => $this->area->getAll()->where('id', '!=', 1),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MailScheduleRequest $request, $id)
    {
        if ($this->mailSchedule->update($request, $id)) {
            \Artisan::call("command:SendMailSchedule", ['id' => $id]);
            $this->setFlash(__('メールの編集が完了しました。'));
            return redirect()->route('system.mail-schedule.index');
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.email-template.update', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->mailSchedule->destroy($id)) {
            return response()->json([
                'message' => 'メールの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
    public function deleteMulti(Request $request) {
        if ($this->mailSchedule->deleteMulti($request->ids)) {
            return response()->json([
                'message' => 'メールの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
