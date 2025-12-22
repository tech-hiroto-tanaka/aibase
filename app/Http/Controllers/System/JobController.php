<?php

namespace App\Http\Controllers\System;

use App\Http\Requests\JobValidate;
use App\Enums\StatusCode;
use App\Repositories\Job\JobInterface;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Prefecture\PrefectureInterface;
use App\Repositories\Skill\SkillInterface;
use App\Repositories\Feature\FeatureInterface;
use App\Repositories\Genre\GenreInterface;
use App\Repositories\DesiredCost\DesiredCostInterface;
use App\Http\Controllers\BaseController;
use App\Enums\ItemType;
use Illuminate\Http\Request;

class JobController extends BaseController
{
    private $prefecture;
    private $skill;
    private $feature;
    private $genre;
    private $desiredCost;
    private $job;
    private $area;
    public function __construct(PrefectureInterface $prefecture, SkillInterface $skill, FeatureInterface $feature,
        GenreInterface $genre, DesiredCostInterface $desiredCost, JobInterface $job, AreaInterface $area)
    {
        $this->prefecture = $prefecture;
        $this->skill = $skill;
        $this->feature = $feature;
        $this->genre = $genre;
        $this->desiredCost = $desiredCost;
        $this->job = $job;
        $this->area = $area;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            '案件一覧',
        ];
        $newSizeLimit = $this->newListLimit($request);
        return view('system.job.index', [
            'title' => '案件一覧',
            'breadcrumbs' => $breadcrumbs,
            'jobs' => $this->job->getJobs($request),
            'request' => $request,
            'newSizeLimit' => $newSizeLimit
        ]);

        // return $this->job->getJobs($request);

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
                'url' => route('system.job.index'),
                'name' => '案件一覧',
            ],
            '案件登録'
        ];
        return view('system.job.create', [
            'title' => '案件登録',
            'breadcrumbs' => $breadcrumbs,
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $this->feature->getAll()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobValidate $request)
    {
        if ($this->job->store($request)) {
            $this->setFlash(__('案件の新規作成が完了しました。'));
            return redirect(route('system.job.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.job.create');
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
        $breadcrumbs = [
            [
                'url' => route('system.job.index'),
                'name' => '案件一覧',
            ],
            '案件編集'
        ];
        $jobInfo = $this->job->getById($id);
        if (!$jobInfo) {
            return redirect(route('system.job.index'));
        }
        return view('system.job.edit', [
            'title' => '案件編集',
            'breadcrumbs' => $breadcrumbs,
            'jobInfo' => $jobInfo,
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $this->feature->getAll()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobValidate $request, $id)
    {
        if ($this->job->update($request, $id)) {
            $this->setFlash(__('案件の編集が完了しました。'));
            return redirect(route('system.job.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.job.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->job->destroy($id)) {
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

    public function checkCode(Request $request)
    {
        return response()->json([
            'valid' => $this->job->checkCode($request),
        ], StatusCode::OK);
    }
}
