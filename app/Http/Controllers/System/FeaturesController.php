<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\FeatureRequest;
use App\Enums\StatusCode;
use App\Repositories\Feature\FeatureInterface;

class FeaturesController extends BaseController
{
    private $feature;
    public function __construct(FeatureInterface $feature)
    {
        $this->feature = $feature;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            '特徴一覧'
        ];

        $newSizeLimit = $this->newListLimit($request);
        return view('system.feature.index', [
            'title' => '特徴一覧',
            'breadcrumbs' => $breadcrumbs,
            'items' => $this->feature->get($request),
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
                'url' => route('system.feature.index'),
                'name' => '特徴一覧',
            ],
            '特徴登録'
        ];

        $order = $this->feature->getMaxOrderNum();

        return view('system.feature.create', [
            'title' => '特徴登録',
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
    public function store(FeatureRequest $request)
    {
        if ($this->feature->store($request)) {
            $this->setFlash(__('特徴の新規作成が完了しました。'));
            return redirect(route('system.feature.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.feature.create');
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
                'url' => route('system.feature.index'),
                'name' => '特徴一覧',
            ],
            '特徴編集'
        ];
        $item = $this->feature->getById($id);
        
        if (!$item) {
            return redirect(route('system.feature.index'));
        }

        return view('system.feature.edit', [
            'title' => '特徴編集',
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
    public function update(FeatureRequest $request, $id)
    {
        if ($this->feature->update($request, $id)) {
            $this->setFlash(__('特徴の編集が完了しました。'));
            return redirect(route('system.feature.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.feature.edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->feature->destroy($id)) {
            return response()->json([
                'message' => '特徴の削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
