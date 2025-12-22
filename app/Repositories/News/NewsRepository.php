<?php

namespace App\Repositories\News;

use Carbon\Carbon;
use App\Components\CommonComponent;
use App\Enums\PublishStatus;
use App\Models\News;
use App\Http\Controllers\BaseController;
use App\Repositories\News\NewsInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class NewsRepository extends BaseController implements NewsInterface
{
    private $news;
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function getNews($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $newBuilder = $this->news;
        if (isset($request['search_input'])) {
            $newBuilder = $newBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('news_title', $request['search_input']));
                // $q->orWhere($this->escapeLikeSentence('notification_body', $request['search_input']));
            });
        }
        $news = $newBuilder->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($news)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $news = $newBuilder->paginate($newSizeLimit);
        }
        return $news;
    }

    public function getById($id)
    {
        return $this->news->where('id', $id)->first();
    }

    public function store($request)
    {
        $data = $request->post();

        // create news url

        // $id= $this->news->orderBy('created_at', 'desc')->first()->id + 1;
        // $data['news_url']= route('user.new.show', $id);

        $data['news_publish_status'] = $request->news_publish_status ? PublishStatus::PUBLISH : PublishStatus::UNPUBLISH;

        if ($request->input('unset_file')) {
            $data['news_file'] = null;
        } elseif ($request->hasFile('news_file')) {
            $file = $request->file('news_file');
            $extension = $file->getClientOriginalExtension();

            $path = CommonComponent::uploadFile('news-file', $file, CommonComponent::uploadFileName($extension));

            if (is_string($path)) {
                $data['news_file_url'] = $path;
                $data['news_file_name'] = $request->file('news_file')->getClientOriginalName();
            } else {
                return false;
            }

        }


        return $this->news->create($data);
    }

    public function update($request, $id)
    {
        $data = $request->post();
        $data['news_publish_status'] = $request->news_publish_status ? PublishStatus::PUBLISH : PublishStatus::UNPUBLISH;

        if ($request->input('unset_file')) {
            $data['news_file'] = null;
        } elseif ($request->hasFile('news_file')) {
            $file = $request->file('news_file');
            $extension = $file->getClientOriginalExtension();

            $path = CommonComponent::uploadFile('news-file', $file, CommonComponent::uploadFileName($extension));

            if (is_string($path)) {
                $data['news_file_url'] = $path;
                $data['news_file_name'] = $request->file('news_file')->getClientOriginalName();
            } else {
                return false;
            }
        }

        return $this->news->find($id)->update($data);
    }

    public function destroy($id)
    {
        $notificationInfo = $this->news->where('id', $id)->first();
        if (!$notificationInfo) {
            return false;
        }
        return $notificationInfo->delete();
    }

    public function getTopNews($limit)
    {
        return $this->news->with([
            'userNew' => function($q) {
                if (Auth::guard('user')->check()) {
                    $q->where('user_id', Auth::guard('user')->user()->id);
                }
            }
        ])->where([
            ['news_publish_status', PublishStatus::PUBLISH],
            ['news_publish_start_datetime', '<', Carbon::now()],
            ['news_publish_end_datetime', '>', Carbon::now()],
        ])->orderBy('news_publish_start_datetime','desc')->limit($limit)->get();
    }
    public function userGetNews($request)
    {
        $newSizeLimit = 10;
        $newBuilder = $this->news;
        $newBuilder = $newBuilder->with([
            'userNew' => function($q) {
                if (Auth::guard('user')->check()) {
                    $q->where('user_id', Auth::guard('user')->user()->id);
                }
            }
        ])->where([
            ['news_publish_status', PublishStatus::PUBLISH],
            ['news_publish_start_datetime', '<', Carbon::now()],
            ['news_publish_end_datetime', '>', Carbon::now()],
        ]);
        $news = $newBuilder->sortable(['news_publish_start_datetime' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($news)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $news = $newBuilder->paginate($newSizeLimit);
        }
        return $news;
    }
    public function getNewPublishById($id)
    {
        return $this->news->where([
            ['id', $id],
            ['news_publish_status', PublishStatus::PUBLISH],
            ['news_publish_start_datetime', '<', Carbon::now()],
            ['news_publish_end_datetime', '>', Carbon::now()],
        ])->first();
    }
}
