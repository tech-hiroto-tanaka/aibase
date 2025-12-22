<?php

namespace App\Http\Controllers\System;

use App\Enums\ContactType;
use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ContactRequest;
use App\Repositories\Contact\ContactInterface;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    private $contact;
    public function __construct(ContactInterface $contact)
    {
        $this->contact = $contact;
    }

    public function index (Request $request) {
        $breadcrumbs = [
            'ユーザーの問い合わせ一覧',
        ];
        $newSizeLimit = $this->newListLimit($request);
        return view('system.contact.index', [
            'title' => 'ユーザーの問い合わせ一覧',
            'breadcrumbs' => $breadcrumbs,
            'contacts' => $this->contact->getContacts($request),
            'request' => $request,
            'newSizeLimit' => $newSizeLimit
        ]);
    }

    public function edit($id)
    {
        $breadcrumbs = [
            [
                'url' => route('system.contact.index'),
                'name' => 'ユーザーの問い合わせ一覧',
            ],
            '連絡先の詳細'
        ];
        $contact = $this->contact->getById($id);
        if (!$contact) {
            return redirect(route('system.contact.index'));
        }
        return view('system.contact.edit', [
            'title' => '連絡先の詳細',
            'breadcrumbs' => $breadcrumbs,
            'contact' => $contact,
            'contactTypes' => ContactType::parseArray()
        ]);
    }

    public function show($id)
    {
        $breadcrumbs = [
            [
                'url' => route('system.contact.index'),
                'name' => 'ユーザーの問い合わせ一覧',
            ],
            'ユーザーの問い合わせ詳細'
        ];
        $contact = $this->contact->getById($id);
        if (!$contact) {
            return redirect(route('system.contact.index'));
        }
        return view('system.contact.edit', [
            'title' => 'ユーザーの問い合わせ詳細',
            'breadcrumbs' => $breadcrumbs,
            'contact' => $contact,
            'contactTypes' => ContactType::parseArray()
        ]);
    }

    public function update(ContactRequest $request, $id)
    {
        if ($this->contact->update($request, $id)) {
            $this->setFlash(__('連絡先ステータスの更新の成功'));
            return redirect(route('system.contact.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.contact.edit', $id);
    }

    public function destroy($id)
    {
        if ($this->contact->destroy($id)) {
            return response()->json([
                'message' => 'お問い合わせを削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => '問い合わせを削除が失敗しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
