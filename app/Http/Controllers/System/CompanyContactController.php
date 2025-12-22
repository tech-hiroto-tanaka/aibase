<?php

namespace App\Http\Controllers\System;

use App\Enums\ContactType;
use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Requests\System\CompanyContactRequest;
use App\Repositories\CompanyContact\CompanyContactInterface;
use Illuminate\Http\Request;

class CompanyContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $companyContact;
    public function __construct(CompanyContactInterface $companyContact)
    {
        $this->companyContact = $companyContact;
    }
    public function index(Request $request)
    {
        $breadcrumbs = [
            '会社の問い合わせ一覧',
        ];
        $newSizeLimit = $this->newListLimit($request);
        return view('system.companyContact.index', [
            'title' => '会社の問い合わせ一覧',
            'breadcrumbs' => $breadcrumbs,
            'companyContacts' => $this->companyContact->getCompanyContacts($request),
            'request' => $request,
            'newSizeLimit' => $newSizeLimit
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
        $breadcrumbs = [
            [
                'url' => route('system.company-contact.index'),
                'name' => '会社の問い合わせ一覧',
            ],
            '会社の問い合わせ詳細'
        ];
        $companyContact = $this->companyContact->getById($id);
        if (!$companyContact) {
            return redirect(route('system.company-contact.index'));
        }
        $companyContact->area_name = $companyContact->area ? $companyContact->area->area_name : '';
        return view('system.companyContact.edit', [
            'title' => '会社の問い合わせ詳細',
            'breadcrumbs' => $breadcrumbs,
            'companyContact' => $companyContact,
            'contactTypes' => ContactType::parseArray()
        ]);
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
    public function update(CompanyContactRequest $request, $id)
    {
        if ($this->companyContact->update($request, $id)) {
            $this->setFlash(__('連絡先ステータスの更新の成功'));
            return redirect(route('system.company-contact.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.company-contact.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->companyContact->destroy($id)) {
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
