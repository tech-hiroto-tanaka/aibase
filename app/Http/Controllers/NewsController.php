<?php

namespace App\Http\Controllers;

use App\Repositories\News\NewsInterface;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    private $new;
    public function __construct(NewsInterface $new)
    {
        $this->new = $new;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('news.index', [
            'title' => 'お知らせ一覧',
            'request' => $request,
            'news' => $this->new->userGetNews($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newInfo = $this->new->getNewPublishById($id);
        if (!$newInfo) {
            return redirect(route('news.index'));
        }
        return view('news.show', [
            'title' => 'お知らせ詳細',
            'newInfo' => $newInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
