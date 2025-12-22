<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Enums\StatusCode;
use App\Repositories\Skill\SkillInterface;
use App\Http\Requests\SkillRequest;

class SkillsController extends BaseController
{
    private $skill;
    public function __construct(SkillInterface $skill)
    {
        $this->skill = $skill;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'スキル一覧'
        ];

        $newSizeLimit = $this->newListLimit($request);
        return view('system.skill.index', [
            'title' => 'スキル一覧',
            'breadcrumbs' => $breadcrumbs,
            'items' => $this->skill->get($request),
            'request' => $request,
            'newSizeLimit' => $newSizeLimit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $breadcrumbs = [
            [
                'url' => route('system.skill.index'),
                'name' => 'スキル一覧',
            ],
            'スキル登録'
        ];
        $order = $this->skill->getMaxOrderNum();

        return view('system.skill.create', [
            'title' => 'スキル登録',
            'breadcrumbs' => $breadcrumbs,
            'order' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkillRequest $request)
    {
        if ($this->skill->store($request)) {
            $this->setFlash(__('スキルの新規作成が完了しました。'));
            return redirect(route('system.skill.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.skill.create');
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
        $breadcrumbs = [
            [
                'url' => route('system.skill.index'),
                'name' => 'スキル一覧',
            ],
            'スキル編集'
        ];
        $item = $this->skill->getById($id);
        
        if (!$item) {
            return redirect(route('system.skill.index'));
        }

        return view('system.skill.edit', [
            'title' => 'スキル編集',
            'breadcrumbs' => $breadcrumbs,
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SkillRequest $request, $id)
    {
        if ($this->skill->update($request, $id)) {
            $this->setFlash(__('スキルの編集が完了しました。'));
            return redirect(route('system.skill.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.skill.edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->skill->destroy($id)) {
            return response()->json([
                'message' => 'スキルの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
