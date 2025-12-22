<?php

namespace App\Repositories\Skill;

use App\Models\Skill;
use App\Http\Controllers\BaseController;
use App\Repositories\Skill\SkillInterface;
use Illuminate\Support\Facades\Auth;
use App\Enums\PublishStatus;
use Illuminate\Pagination\Paginator;

class SkillRepository extends BaseController implements SkillInterface
{
    private Skill $skill;
    public function __construct(Skill $skill)
    {
        $this->skill = $skill;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $skillBuilder = $this->skill;

        if (isset($request['search_input'])) {
            $skillBuilder = $skillBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('skill_name', $request['search_input']));
            });
        }

        $newList = $skillBuilder->sortable(['order_number' => 'asc'])->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($newList)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $newList = $skillBuilder->paginate($newSizeLimit);
        }
        return $newList;
    }

    public function getById($id)
    {
        return $this->skill->where(['id'=>$id])->first();
    }

    public function store($request)
    {
        $this->skill->skill_name = $request->skill_name;
        $this->skill->order_number = (int) $request->order_number;
        return $this->skill->save();
    }

    public function update($request, $id)
    {
        $item = $this->skill->where('id', $id)->first();
        if (!$item) {
            return false;
        }
        $item->skill_name = $request->skill_name;
        $item->order_number = $request->order_number;
        return $item->save();
    }

    public function destroy($id)
    {
        $skillInfo = $this->skill->where(['id'=> $id])->first();
        if (!$skillInfo) {
            return false;
        }
        return $skillInfo->delete();
    }
    public function getAll()
    {
        return $this->skill->orderBy('order_number')->get();
    }

    public function getMaxOrderNum(){
        $sortNo = $this->skill->max('order_number');

        return $sortNo;
    }
}
