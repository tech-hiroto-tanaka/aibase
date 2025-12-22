<?php

namespace App\Repositories\DesiredCost;

use App\Models\DesiredCost;
use App\Http\Controllers\BaseController;
use App\Repositories\DesiredCost\DesiredCostInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class DesiredCostRepository extends BaseController implements DesiredCostInterface
{
    private DesiredCost $desiredCost;
    public function __construct(DesiredCost $desiredCost)
    {
        $this->desiredCost = $desiredCost;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $desiredCostBuilder = $this->desiredCost;

        if (isset($request['search_input'])) {
            $desiredCostBuilder = $desiredCostBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('desired_cost_name', $request['search_input']));
            });
        }

        $newList = $desiredCostBuilder->sortable(['order_number' => 'asc'])->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($newList)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $newList = $desiredCostBuilder->paginate($newSizeLimit);
        }
        return $newList;
    }

    public function getById($id)
    {
        return $this->desiredCost->where(['id'=>$id])->first();
    }

    public function store($request)
    {
        $this->desiredCost->desired_cost_name = $request->desired_cost_name;
        $this->desiredCost->order_number = $request->order_number;
        $this->desiredCost->money = $request->money;
        return $this->desiredCost->save();
    }

    public function update($request, $id)
    {
        $item = $this->desiredCost->where('id', $id)->first();
        if (!$item) {
            return false;
        }
        $item->desired_cost_name = $request->desired_cost_name;
        $item->order_number = $request->order_number;
        $item->money = $request->money;
        return $item->save();
    }

    public function destroy($id)
    {
        $desiredCostInfo = $this->desiredCost->where(['id'=> $id])->first();
        if (!$desiredCostInfo) {
            return false;
        }
        return $desiredCostInfo->delete();
    }
    public function getAll()
    {
        return $this->desiredCost->orderBy('order_number')->get();
    }

    public function getMaxOrderNum(){
        $sortNo = $this->desiredCost->max('order_number');

        return $sortNo;
    }
}
