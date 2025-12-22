<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ItemMasterRequest;
use App\Enums\StatusCode;
use App\Enums\ItemType;
class ItemMasterController extends BaseController
{

    /**
     * Display a listing of the resource.
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->type ?? ItemType::GENRE;
        $breadcrumbs = [
            ItemType::getDescription($type) . '一覧'
        ];

        $newSizeLimit = $this->newListLimit($request);
        return view('system.itemMaster.index', [
            'title' => ItemType::getDescription($type) . '一覧',
            'breadcrumbs' => $breadcrumbs,
            'items' => $this->itemMaster->getItemsMaster($request, $type),
            'request' => $request,
            'newSizeLimit' => $newSizeLimit,
            'type' => $type
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->type ?? ItemType::GENRE;
        $breadcrumbs = [
            [
                'url' => route('system.item-master.index', ['type' => $type]),
                'name' => ItemType::getDescription($type) . '一覧',
            ],
            ItemType::getDescription($type) . '作成'
        ];

        return view('system.itemMaster.create', [
            'title' => ItemType::getDescription($type) . '作成',
            'type' => $type,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ItemMasterRequest  $request
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function store(ItemMasterRequest $request)
    {
        $type = $request->type ?? ItemType::GENRE;
        if ($this->itemMaster->store($request)) {
            $this->setFlash(__('アイテムマスターの新規作成が完了しました。'));
            return redirect(route('system.item-master.index', ['type' => $type]));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.item-master.create', ['type' => $type]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $type = $request->type ?? ItemType::GENRE;
        $breadcrumbs = [
            [
                'url' => route('system.item-master.index', ['type' => $type]),
                'name' => ItemType::getDescription($type) . '一覧',
            ],
            ItemType::getDescription($type) . '編集'
        ];
        $item = $this->itemMaster->getById($type, $id);
        if (!$item) {
            return redirect(route('system.item-master.index', ['type' => $type]));
        }

        return view('system.itemMaster.edit', [
            'title' => ItemType::getDescription($type) . '編集',
            'breadcrumbs' => $breadcrumbs,
            'item' => $item,
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ItemMasterRequest  $request
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemMasterRequest $request, $id)
    {
        $type = $request->type ?? ItemType::GENRE;
        if ($this->itemMaster->update($request, $type, $id)) {
            $this->setFlash(__('代理店の新規作成が完了しました。'));
            return redirect(route('system.item-master.index', ['type' => $type]));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.item-master.edit', [$id, 'type' => $type]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($this->itemMaster->destroy($request->type ?? ItemType::GENRE, $id)) {
            return response()->json([
                'message' => 'アイテムマスターの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
