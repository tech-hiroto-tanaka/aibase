<?php

namespace App\Http\Controllers;

use App\Repositories\Job\JobInterface;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Skill\SkillInterface;
use App\Repositories\Feature\FeatureInterface;
use App\Repositories\Genre\GenreInterface;
use App\Repositories\DesiredCost\DesiredCostInterface;
use App\Repositories\News\NewsInterface;
use Illuminate\Http\Request;

class TopController extends BaseController
{
    private $skill;
    private $feature;
    private $genre;
    private $desiredCost;
    private $job;
    private $area;
    private $new;
    public function __construct(NewsInterface $new,SkillInterface $skill, FeatureInterface $feature,
        GenreInterface $genre, DesiredCostInterface $desiredCost, JobInterface $job, AreaInterface $area)
    {
        $this->skill = $skill;
        $this->feature = $feature;
        $this->genre = $genre;
        $this->desiredCost = $desiredCost;
        $this->job = $job;
        $this->area = $area;
        $this->new = $new;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featureMasters = $this->feature->getAll();
        $jobNews = $this->job->getJobNew(10);

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
        return view('top.index', [
            'title' => 'トップページ',
            'jobNews' => $jobNews,
            'topNews' => $this->new->getTopNews(5),
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $featureMasters
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
