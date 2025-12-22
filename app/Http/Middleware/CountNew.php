<?php

namespace App\Http\Middleware;

use App\Enums\PublishStatus;
use App\Models\News;
use App\Models\UserNews;
use App\Repositories\Area\AreaInterface;
use App\Repositories\DesiredCost\DesiredCostInterface;
use App\Repositories\Feature\FeatureInterface;
use App\Repositories\Genre\GenreInterface;
use App\Repositories\Job\JobInterface;
use App\Repositories\Skill\SkillInterface;
use Carbon\Carbon;
use Closure;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Auth;

class CountNew
{
    private $skill;
    private $feature;
    private $genre;
    private $desiredCost;
    private $job;
    private $area;
    public function __construct
    (
        Factory $viewFactory,
        SkillInterface $skill,
        FeatureInterface $feature,
        GenreInterface $genre,
        DesiredCostInterface $desiredCost,
        JobInterface $job,
        AreaInterface $area
    ){
        $this->viewFactory = $viewFactory;
        $this->skill = $skill;
        $this->feature = $feature;
        $this->genre = $genre;
        $this->desiredCost = $desiredCost;
        $this->job = $job;
        $this->area = $area;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $countNewUnRead = 0;
        if (Auth::guard('user')->check()) {
            $routeName = \Route::currentRouteName();
            if ($routeName == 'news.show') {
                $new = News::where([
                    ['news_publish_status', PublishStatus::PUBLISH],
                    ['news_publish_start_datetime', '<', Carbon::now()],
                    ['news_publish_end_datetime', '>', Carbon::now()],
                ])->first();
                if (!$new) {
                    abort(404);
                }
                $userNew = UserNews::where([
                    ['user_id', Auth::guard('user')->user()->id],
                    ['new_id', $request->news],
                ])->first();
                if (!$userNew) {
                    $userNew = new UserNews();
                    $userNew->user_id = Auth::guard('user')->user()->id;
                    $userNew->new_id = $request->news;
                    $userNew->save();
                }
            }
            $countNewUnRead = News::leftJoin('user_news', function ($join) {
                $join->on('news.id', '=', 'user_news.new_id');
                $join->where('user_news.user_id', Auth::guard('user')->user()->id);
            })
                ->where([
                    ['news_publish_status', PublishStatus::PUBLISH],
                    ['news_publish_start_datetime', '<', Carbon::now()],
                    ['news_publish_end_datetime', '>', Carbon::now()],
                ])
                ->whereNull('user_news.user_id')
                ->count();
        }
        $data = [
            'genreMasters' => $this->genre->getAll(),
            'areaMasters' => $this->area->getAll(),
            'skillWordMasters' => $this->skill->getAll(),
            'desiredUnitPriceMasters' => $this->desiredCost->getAll(),
            'featureMasters' => $this->feature->getAll(),
            'urlSearch' => route('search.store'),
            'request' => $request->all(),
            'totalJob' => $this->job->searchJob($request, 1)->total(),
        ];
        view()->share('countNewUnRead', $countNewUnRead);
        view()->share('dataShare', $data);
        return $next($request);
    }
}
