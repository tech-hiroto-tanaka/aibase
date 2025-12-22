<?php

namespace App\Repositories\Area;

use App\Models\Area;
use App\Models\AreaPrefecture;
use App\Http\Controllers\BaseController;
use App\Repositories\Area\AreaInterface;
use Illuminate\Support\Facades\Auth;
use App\Enums\PublishStatus;
use Illuminate\Pagination\Paginator;

class AreaRepository extends BaseController implements AreaInterface
{
    private Area $area;
    private AreaPrefecture $areaPrefecture;
    public function __construct(Area $area, AreaPrefecture $areaPrefecture)
    {
        $this->area = $area;
        $this->areaPrefecture = $areaPrefecture;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $areaBuilder = $this->area->with([
            'areaPrefectures',
            'areaPrefectures.prefecture'
        ]);

        if (isset($request['search_input'])) {
            $areaBuilder = $areaBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('area_name', $request['search_input']));
            });
        }

        $newList = $areaBuilder->sortable(['order_number' => 'asc'])->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($newList)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $newList = $areaBuilder->paginate($newSizeLimit);
        }
        return $newList;
    }

    public function getById($id)
    {
        return $this->area->where('id', $id)->with(['AreaPrefectures'])->first();
    }

    public function store($request)
    {
        $this->area->area_name = $request->area_name;
        $this->area->order_number = $request->order_number;
        if (!$this->area->save()) {
            return false;
        }
        if ($request->prefectures) {
            foreach ($request->prefectures as $key => $item) {
                $areaPref = new $this->areaPrefecture();
                $areaPref->area_id = $this->area->id;
                $areaPref->prefecture_id = $item;
                if (!$areaPref->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    public function update($request, $id)
    {
        $item = $this->area->where('id', $id)->first();
        if (!$item) {
            return false;
        }
        $item->area_name = $request->area_name;
        $item->order_number = $request->order_number;
        if (!$item->save()) {
            return false;
        }
        $this->areaPrefecture->where('area_id', $item->id)->delete();
        if ($request->prefectures) {
            foreach ($request->prefectures as $key => $pref) {
                $areaPref = new $this->areaPrefecture();
                $areaPref->area_id = $item->id;
                $areaPref->prefecture_id = $pref;
                if (!$areaPref->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    public function destroy($id)
    {
        $areaInfo = $this->area->where(['id'=> $id])->first();
        if (!$areaInfo) {
            return false;
        }
        return $areaInfo->delete();
    }
    public function getAll()
    {
        return $this->area->orderBy('order_number')->with([
            'areaPrefectures',
            'areaPrefectures.prefecture'
        ])->get();
    }

    public function getMaxOrderNum(){
        $sortNo = $this->area->max('order_number');

        return $sortNo;
    }
}
