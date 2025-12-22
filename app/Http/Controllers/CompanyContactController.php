<?php

namespace App\Http\Controllers;

use App\Enums\Area;
use App\Enums\StatusCode;
use App\Http\Requests\CompanyContactRequest;
use App\Repositories\Area\AreaInterface;
use App\Repositories\CompanyContact\CompanyContactInterface;
use Illuminate\Http\Request;

class CompanyContactController extends BaseController
{
    private $area;
    private $companyContact;
    public function __construct(AreaInterface $area, CompanyContactInterface $companyContact)
    {
        $this->area = $area;
        $this->companyContact = $companyContact;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areasMaster = $this->area->getAll()->where('id', '!=', 1);
        foreach ($areasMaster as $area) {
            $areas[] = ['label' => $area['area_name'], 'id' => $area['id']];
        }
        return view('companyContact.create', [
            'title' => 'お問い合わせ（エンジニアをお探しの企業様専用）',
            'areas' => $areas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyContactRequest $request)
    {
        if ($this->companyContact->store($request)) {
            // $this->setFlash(__('新しく作成された会社の連絡先'));
            return redirect(route('contact.success'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('company-contact.index');
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

    public function checkEmail(Request $request)
    {
        return response()->json([
            'valid' => $this->companyContact->checkEmail($request),
        ], StatusCode::OK);
    }
}
