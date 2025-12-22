<?php

namespace App\Http\Controllers\System;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Requests\MailTemplateRequest;
use App\Models\MailTemplate;
use App\Repositories\MailMaster\MailMasterInterface;
use App\Repositories\MailTemplate\MailTemplateInterface;
use Illuminate\Http\Request;

class MailTemplateController extends BaseController
{
    private MailTemplateInterface $template;
    private MailMasterInterface $mailMaster;

    public function __construct(MailTemplateInterface $template, MailMasterInterface $mailMaster)
    {
        $this->template = $template;
        $this->mailMaster = $mailMaster;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('system.mailTemplate.index', [
            'title' => 'メールテンプレート一覧',
            'breadcrumbs' => ['メールテンプレート一覧'],
            'newSizeLimit' => $this->newListLimit($request),
            'templates' => $this->template->get($request),
            'request' => $request
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        return view('system.mailTemplate.create', [
            'title' => '新規メールテンプレート作成',
            'breadcrumbs' => [
                ['url' => route('system.mail-template.index'), 'name' => 'メールテンプレート一覧'],
                '新規メールテンプレート作成'
            ],
            'item' => $this->template,
            'mailMasters' => $this->mailMaster->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(MailTemplateRequest $request)
    {
        if ($this->template->store($request)) {
            $this->setFlash(__('メールテンプレートの新規作成が完了しました。'));
            return redirect(route('system.mail-template.index'));
        }

        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.mail-template.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function show($id)
    {
        $item = $this->template->getById($id);
        if (request()->input('ajax')) {
            return response()->json([
                'status' => 1,
                'data' => $item
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        $template = $this->template->getById($id);
        if (!$template) {
            return redirect(route('system.mail-template.index'));
        }
        return view('system.mailTemplate.edit', [
            'template' => $template,
            'title' => '新規メールテンプレート編集',
            'breadcrumbs' => [
                ['url' => route('system.mail-template.index'), 'name' => 'メールテンプレート一覧'],
                '新規メールテンプレート編集'
            ],
            'mailMasters' => $this->mailMaster->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(MailTemplateRequest $request, $id)
    {
        $template = $this->template->getById($id);
        if (!$template) {
            return redirect(route('system.mail-template.index'));
        }
        if ($this->template->update($request, $id)) {
            $this->setFlash(__('メールテンプレートの編集が完了しました。'));
            return redirect()->route('system.mail-template.index');
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.mail-template.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        if ($this->template->destroy($id)) {
            return response()->json([
                'message' => 'メールテンプレートの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
    public function deleteMulti(Request $request) {
        if ($this->template->deleteMulti($request->ids)) {
            return response()->json([
                'message' => 'メールテンプレートの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
