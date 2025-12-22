<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Repositories\DesiredCost\DesiredCostInterface;
use App\Http\Requests\DesiredCostRequest;
use App\Enums\StatusCode;

class DesiredCostsController extends BaseController
{
    private $desiredCost;
    public function __construct(DesiredCostInterface $desiredCost)
    {
        $this->desiredCost = $desiredCost;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            '希望単価一覧'
        ];

        $newSizeLimit = $this->newListLimit($request);
        return view('system.desiredCost.index', [
            'title' => '希望単価一覧',
            'breadcrumbs' => $breadcrumbs,
            'items' => $this->desiredCost->get($request),
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
                'url' => route('system.desired-cost.index'),
                'name' => '希望単価一覧',
            ],
            '希望単価登録'
        ];
        $order = $this->desiredCost->getMaxOrderNum();

        return view('system.desiredCost.create', [
            'title' => '希望単価登録',
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
    public function store(DesiredCostRequest $request)
    {
        if ($this->desiredCost->store($request)) {
            $this->setFlash(__('希望単価の新規作成が完了しました。'));
            return redirect(route('system.desired-cost.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.desired-cost.create');
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
                'url' => route('system.desired-cost.index'),
                'name' => '希望単価一覧',
            ],
            '希望単価編集'
        ];
        $item = $this->desiredCost->getById($id);
        
        if (!$item) {
            return redirect(route('system.desired-cost.index'));
        }

        return view('system.desiredCost.edit', [
            'title' => '希望単価編集',
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
    public function update(DesiredCostRequest $request, $id)
    {
        if ($this->desiredCost->update($request, $id)) {
            $this->setFlash(__('希望単価の編集が完了しました。'));
            return redirect(route('system.desired-cost.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.desired-cost.edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->desiredCost->destroy($id)) {
            return response()->json([
                'message' => '希望単価の削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
