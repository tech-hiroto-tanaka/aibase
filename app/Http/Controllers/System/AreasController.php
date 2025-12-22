<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Prefecture\PrefectureInterface;
use App\Http\Requests\AreaRequest;
use App\Enums\StatusCode;
class AreasController extends BaseController
{
    private $area;
    private $prefecture;
    private $areaSelect = [
        ['id' => 1, 'name' => 'フルリモートエリア'],
        ['id' => 2, 'name' => '北海道・東北エリア'],
        ['id' => 3, 'name' => '関東エリア'],
        ['id' => 4, 'name' => '北陸・甲信越エリア'],
        ['id' => 5, 'name' => '東海エリア'],
        ['id' => 6, 'name' => '関西エリア'],
        ['id' => 7, 'name' => '中国・四国エリア'],
        ['id' => 8, 'name' => '九州エリア'],
    ];
    public function __construct(AreaInterface $area, PrefectureInterface $prefecture)
    {
        $this->area = $area;
        $this->prefecture = $prefecture;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'エリア一覧'
        ];

        $newSizeLimit = $this->newListLimit($request);
        return view('system.area.index', [
            'title' => 'エリア一覧',
            'breadcrumbs' => $breadcrumbs,
            'items' => $this->area->get($request),
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
        // $breadcrumbs = [
        //     [
        //         'url' => route('system.area.index'),
        //         'name' => 'エリア一覧',
        //     ],
        //     'エリア登録'
        // ];

        // $order = $this->area->getMaxOrderNum();

        // return view('system.area.create', [
        //     'title' => 'エリア登録',
        //     'breadcrumbs' => $breadcrumbs,
        //     'order' => $order,
        //     'prefectures' => $this->prefecture->getAll(),
        //     'areaSelect' => $this->areaSelect
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        // $request->area_name = collect($this->areaSelect)->where('id', $request->area_id)->first()['name'];
        // if ($this->area->store($request)) {
        //     $this->setFlash(__('エリアの新規作成が完了しました。'));
        //     return redirect(route('system.area.index'));
        // }
        // $this->setFlash(__('エラーが発生しました。'), 'error');
        // return redirect()->route('system.area.create');
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
                'url' => route('system.area.index'),
                'name' => 'エリア一覧',
            ],
            'エリア編集'
        ];
        $item = $this->area->getById($id);
        if (!$item) {
            return redirect(route('system.area.index'));
        }
        $item->area_id = collect($this->areaSelect)->where('name', $item->area_name)->first()['id'];
        return view('system.area.edit', [
            'title' => 'エリア編集',
            'breadcrumbs' => $breadcrumbs,
            'item' => $item,
            'prefectures' => $this->prefecture->getAll(),
            'areaSelect' => $this->areaSelect
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, $id)
    {
        $request->area_name = collect($this->areaSelect)->where('id', $request->area_id)->first()['name'];
        if ($this->area->update($request, $id)) {
            $this->setFlash(__('エリアの編集が完了しました。'));
            return redirect(route('system.area.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.area.edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->area->destroy($id)) {
            return response()->json([
                'message' => 'エリアの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
