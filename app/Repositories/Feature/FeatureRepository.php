<?php

namespace App\Repositories\Feature;

use App\Models\Feature;
use App\Http\Controllers\BaseController;
use App\Repositories\Feature\FeatureInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class FeatureRepository extends BaseController implements FeatureInterface
{
    private Feature $feature;
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $featureBuilder = $this->feature;

        if (isset($request['search_input'])) {
            $featureBuilder = $featureBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('feature_name', $request['search_input']));
            });
        }

        $newList = $featureBuilder->sortable(['order_number' => 'asc'])->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($newList)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $newList = $featureBuilder->paginate($newSizeLimit);
        }
        return $newList;
    }

    public function getById($id)
    {
        return $this->feature->where(['id'=>$id])->first();
    }

    public function store($request)
    {
        $this->feature->feature_name = $request->feature_name;
        $this->feature->order_number = $request->order_number;;
        return $this->feature->save();
    }

    public function update($request, $id)
    {
        $item = $this->feature->where('id', $id)->first();
        if (!$item) {
            return false;
        }
        $item->feature_name = $request->feature_name;
        $item->order_number = $request->order_number;
        return $item->save();
    }

    public function destroy($id)
    {
        $featureInfo = $this->feature->where(['id'=> $id])->first();
        if (!$featureInfo) {
            return false;
        }
        return $featureInfo->delete();
    }
    public function getAll()
    {
        return $this->feature->orderBy('order_number')->get();
    }

    public function getMaxOrderNum(){
        $sortNo = $this->feature->max('order_number');

        return $sortNo;
    }
}
