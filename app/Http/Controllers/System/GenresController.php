<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use App\Http\Requests\GenreRequest;
use Illuminate\Http\Request;
use App\Enums\StatusCode;
use App\Repositories\Genre\GenreInterface;

class GenresController extends BaseController
{

    private $genre;
    public function __construct(GenreInterface $genre)
    {
        $this->genre = $genre;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'ジャンル一覧'
        ];

        $newSizeLimit = $this->newListLimit($request);
        return view('system.genre.index', [
            'title' => 'ジャンル一覧',
            'breadcrumbs' => $breadcrumbs,
            'items' => $this->genre->get($request),
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
                'url' => route('system.genre.index'),
                'name' => 'ジャンル一覧',
            ],
            'ジャンル登録'
        ];

        $order = $this->genre->getMaxOrderNum();

        return view('system.genre.create', [
            'title' => 'ジャンル登録',
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
    public function store(GenreRequest $request)
    {
        if ($this->genre->store($request)) {
            $this->setFlash(__('ジャンルの新規作成が完了しました。'));
            return redirect(route('system.genre.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.genre.create');
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
                'url' => route('system.genre.index'),
                'name' => 'ジャンル一覧',
            ],
            'ジャンル編集'
        ];
        $item = $this->genre->getById($id);
        
        if (!$item) {
            return redirect(route('system.genre.index'));
        }

        return view('system.genre.edit', [
            'title' => 'ジャンル編集',
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
    public function update(GenreRequest $request, $id)
    {
        if ($this->genre->update($request, $id)) {
            $this->setFlash(__('ジャンルの編集が完了しました。'));
            return redirect(route('system.genre.index'));
        }
        $this->setFlash(__('エラーが発生しました。'), 'error');
        return redirect()->route('system.genre.edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->genre->destroy($id)) {
            return response()->json([
                'message' => 'ジャンルの削除が完了しました。',
                'status' => StatusCode::OK
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'エラーが発生しました。',
            'status' => StatusCode::OK
        ], StatusCode::INTERNAL_ERR);
    }
}
