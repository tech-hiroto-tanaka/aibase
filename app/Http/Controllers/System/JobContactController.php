<?php

namespace App\Http\Controllers\System;

use App\Enums\ContactType;
use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Http\Requests\ContactRequest;
use App\Repositories\Area\AreaInterface;
use App\Repositories\JobContact\JobContactInterface;
use App\Repositories\Skill\SkillInterface;
use Illuminate\Http\Request;

class JobContactController extends BaseController

{
    private $app;
    private $skill;
    private $area;

    public function __construct(JobContactInterface $app, SkillInterface $skill, AreaInterface $area)
    {
        $this->app = $app;
        $this->skill = $skill;
        $this->area = $area;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $breadcrumbs = [
            '求人応募 ',
        ];
        // dd($this->app->getJobContact($request)->toArray());
        $newSizeLimit = $this->newListLimit($request);
        return view('system.job-contact.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => '求人応募',
            'jobContact' => $this->app->getJobContact($request),
            'request' => $request,
            'newSizeLimit' => $newSizeLimit
        ]);
        // return $jobContact = $this->app->getJobContact($request);
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
                'url' => route('system.job-contact.index'),
                'name' => '案件一覧',
            ],
            '連絡先の詳細 ',
        ];

        $jobContact = $this->app->getById($id);
        return view('system.job-contact.detail', [
            'breadcrumbs' => $breadcrumbs,
            'jobContact' => $jobContact,
            'title' => '連絡先の詳細',
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'contactTypes' => ContactType::parseArray()
        ]);

        // return $jobContact;
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
    public function update(ContactRequest $request, $id)
    {
        if ($this->app->update($request, $id)) {
            $this->setFlash(__('連絡先ステータスの更新の成功'));
            return redirect(route('system.job-contact.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.job-contact.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->app->destroy($id)) {
            return response()->json([
                'message' => '案件の削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
