<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserContact;
use App\Repositories\Contact\ContactInterface;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    private $contact;
    public function __construct(ContactInterface $contact)
    {

        $this->contact = $contact;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('contact.index',[
            'title' => 'お問い合わせ',
            'message' => $request->message,
            'request' => $request->all(),
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
    public function store(UserContact $request)
    {
        if (!$this->contact->store($request)) {
            $this->setFlash(__('エラーが発生しました。'), 'error');
            return redirect(route('contact.index'));
        }
        // $this->setFlash(__('お問い合わせの送信が完了しました。'));
        return redirect(route('contact.success'));
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

    public function success(Request $request)
    {
        return view('contact.success',[
            'title' => 'お問い合わせ完了',
        ]);
    }
}
