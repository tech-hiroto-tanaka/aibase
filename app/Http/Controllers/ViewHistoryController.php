<?php

namespace App\Http\Controllers;

use App\Repositories\Job\JobInterface;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Skill\SkillInterface;
use App\Repositories\Feature\FeatureInterface;
use App\Repositories\Genre\GenreInterface;
use App\Repositories\DesiredCost\DesiredCostInterface;
use App\Repositories\Favorite\FavoriteInterface;
use Illuminate\Http\Request;

class ViewHistoryController extends BaseController
{
    private $skill;
    private $feature;
    private $genre;
    private $desiredCost;
    private $job;
    private $area;
    private $favorite;
    public function __construct(SkillInterface $skill, FeatureInterface $feature, FavoriteInterface $favorite,
        GenreInterface $genre, DesiredCostInterface $desiredCost, JobInterface $job, AreaInterface $area)
    {
        $this->skill = $skill;
        $this->feature = $feature;
        $this->genre = $genre;
        $this->desiredCost = $desiredCost;
        $this->job = $job;
        $this->area = $area;
        $this->favorite = $favorite;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $featureMasters = $this->feature->getAll();
        $jobViewHistories = $this->job->getJobViewHistories($request);
        foreach ($jobViewHistories as &$jobNew) {
            $featureText = [];
            foreach ($jobNew->features as $value) {
                $feature = $featureMasters->where('id', $value['id'])->first();
                if ($feature) {
                    $featureText[] = $feature->feature_name;
                }
            }
            $jobNew->featureText = $featureText;
        }
        return view('viewHistory.index', [
            'title' => '閲覧履歴',
            'jobViewHistories' => $jobViewHistories,
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $featureMasters,
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
}
