<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Repositories\Job\JobInterface;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Skill\SkillInterface;
use App\Repositories\Feature\FeatureInterface;
use App\Repositories\Genre\GenreInterface;
use App\Repositories\DesiredCost\DesiredCostInterface;
use App\Repositories\UserViewHistory\UserViewHistoryInterface;
use App\Repositories\Prefecture\PrefectureInterface;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    private $skill;
    private $feature;
    private $genre;
    private $desiredCost;
    private $job;
    private $area;
    private $userViewHistory;
    private $prefecture;
    public function __construct(UserViewHistoryInterface $userViewHistory, SkillInterface $skill, FeatureInterface $feature,
        GenreInterface $genre, DesiredCostInterface $desiredCost, JobInterface $job, AreaInterface $area, PrefectureInterface $prefecture)
    {
        $this->skill = $skill;
        $this->feature = $feature;
        $this->genre = $genre;
        $this->desiredCost = $desiredCost;
        $this->job = $job;
        $this->area = $area;
        $this->userViewHistory = $userViewHistory;
        $this->prefecture = $prefecture;
        $this->middleware('user')->only(['show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        session()->forget('searchData');
        session()->push('searchData', $request->all());
        $featureMasters = $this->feature->getAll();
        $jobResults = $this->job->searchJob($request, 6);
        foreach ($jobResults as &$jobNew) {
            $featureText = [];
            foreach ($jobNew->features as $value) {
                $feature = $featureMasters->where('id', $value['id'])->first();
                if ($feature) {
                    $featureText[] = $feature->feature_name;
                }
            }
            $jobNew->featureText = $featureText;
        }

        return view('search.index', [
            'title' => '案件一覧',
            'jobResults' => $jobResults,
            // 'jobNews' => $this->job->getJobNew(10),
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $featureMasters,
            'prefectureMasters' => $this->prefecture->getAll(),
            'request' => $request
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
        if($request->ajax()) {
            $jobResults = $this->job->searchJob($request, 1);
            return response()->json([
                'status' => StatusCode::OK,
                'total' => $jobResults->total()
            ], StatusCode::OK);
        }
        $featureMasters = $this->feature->getAll();
        $jobResults = $this->job->searchJob($request, 6);
        foreach ($jobResults as &$jobNew) {
            $featureText = [];
            foreach ($jobNew->features as $value) {
                $feature = $featureMasters->where('id', $value['id'])->first();
                if ($feature) {
                    $featureText[] = $feature->feature_name;
                }
            }
            $jobNew->featureText = $featureText;
        }
        return view('search.index', [
            'jobResults' => $jobResults,
            // 'jobNews' => $this->job->getJobNew(10),
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $featureMasters,
            'prefectureMasters' => $this->prefecture->getAll(),
            'request' => $request
        ]);
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
        // dd($jobInfo->toArray());
        $this->userViewHistory->store($id);
        $jobSuggest = $this->job->getJobSuggest($jobInfo);
        $jobSkills = collect($jobInfo->skills)->pluck('id', 'id')->all();
        $jobAreas = collect($jobInfo->areas)->pluck('id', 'id')->all();
        $convert = [];
        foreach ($jobSuggest as $key => $job) {
            $countSkill = 0;
            $countArea = 0;
            foreach ($job->skills as $key => $value) {
                if (isset($jobSkills[$value['id']])) {
                    $countSkill++;
                }
            }
            foreach ($job->areas as $key => $value) {
                if (isset($jobAreas[$value['id']])) {
                    $countArea++;
                }
            }
            $convert[] = [
                'count_skill' => $countSkill,
                'count_area' => $countArea,
                'job' => $job,
            ];
        }
        $convert = collect($convert)->sortByDesc('count_skill')->sortByDesc('count_area')->pluck('job')->take(10)->all();

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
        $jobResults = $this->job->searchJob($request, 1);

        $featureMasters = $this->feature->getAll();
        $jobNews = $convert ? $convert : $this->job->getJobNew(10);
        foreach ($jobNews as &$jobNew) {
            $featureText = [];
            foreach ($jobNew->features as $value) {
                $feature = $featureMasters->where('id', $value['id'])->first();
                if ($feature) {
                    $featureText[] = $feature->feature_name;
                }
            }
            $jobNew->featureText = $featureText;
        }
        $featureTxt = [];
        foreach ($jobInfo->features as $key => $value) {
            $feature = $featureMasters->where('id', $value['id'])->first();
            if (!$feature) {
                continue;
            }
            $featureTxt[] = $feature->feature_name;
        }
        return view('search.detail', [
            'title' => '案件詳細',
            'jobInfo' => $jobInfo,
            'dataAddress' => $dataAddress,
            'featureTxt' => join(", ", $featureTxt),
            'jobResults' => $jobResults,
            'jobNews' => $jobNews,
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $areaMasters,
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $featureMasters,
            'prefectureMasters' => $this->prefecture->getAll(),
            'request' => $request
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
