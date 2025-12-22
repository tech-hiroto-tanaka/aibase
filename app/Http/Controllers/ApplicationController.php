<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Repositories\Job\JobInterface;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Skill\SkillInterface;
use App\Repositories\Feature\FeatureInterface;
use App\Repositories\Genre\GenreInterface;
use App\Repositories\DesiredCost\DesiredCostInterface;
use Illuminate\Http\Request;

class ApplicationController extends BaseController
{
    private $skill;
    private $feature;
    private $genre;
    private $desiredCost;
    private $job;
    private $area;
    public function __construct(SkillInterface $skill, FeatureInterface $feature,
        GenreInterface $genre, DesiredCostInterface $desiredCost, JobInterface $job, AreaInterface $area)
    {
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
    public function index()
    {
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
        $request = session()->get('searchData')[0] ?? [];
        $jobInfo = $this->job->jobPublicById($id);
        if (!$jobInfo) {
            return redirect(route('search.index', $request));
        }
        $areaMasters = $this->area->getAll();
        $dataAddress = [];
        $prefectureIds = collect($jobInfo->prefectures)->pluck('id', 'id')->all();
        foreach ($areaMasters as $value) {
            $item = ['area_name' => ''];
            $areaInfo = collect($jobInfo->areas)->where('id', $value['id'])->first();
            if ($areaInfo) {
                $item['area_name'] = $value->area_name;
            }
            $namePref = [];
            foreach ($value->areaPrefectures as $areaPrefecture) {
                if (!$areaPrefecture->prefecture || !isset($prefectureIds[$areaPrefecture->prefecture->id])) {
                    continue;
                }
                $namePref[] = $areaPrefecture->prefecture->prefecture_name;
            }
            $item['pref_name'] = join(", ", $namePref);
            if ($item['area_name'] || $item['pref_name']) {
                $dataAddress[] = $item;
            }
        }
        $featureMasters = $this->feature->getAll();
        $featureTxt = [];
        foreach ($jobInfo->features as $key => $value) {
            $feature = $featureMasters->where('id', $value['id'])->first();
            if (!$feature) {
                continue;
            }
            $featureTxt[] = $feature->feature_name;
        }
        return view('application.show', [
            'title' => '案件申込確認',
            'jobInfo' => $jobInfo,
            'featureTxt' => join(', ', $featureTxt),
            'dataAddress' => $dataAddress,
            'areaMasters' => $areaMasters,
            'skillWordMasters' => $this->skill->getAll(),
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
    public function update(Request $request, $id)
    {
        $request = session()->get('searchData')[0] ?? [];
        $jobInfo = $this->job->jobPublicById($id);
        if (!$jobInfo) {
            return redirect(route('search.index', $request));
        }
        if ($this->job->userRegisterApp($id)) {
            return redirect(route('user.application.complete'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect(route('top.index'));
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

    public function complete()
    {
        return view('application.complete',[
            'title' => '案件申込完了'
        ]);
    }
}
