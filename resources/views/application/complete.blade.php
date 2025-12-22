@extends('layouts.user')

@section('content')
   <div class="application-page application-complete">
       <div class="container application-container">
           <div class="header-title">
               <h2 class="application-title">お申し込み完了</h2>
           </div>
           <div class="application-content">
               <h3 class="content-title">お申し込みありがとうございました。<br>
                ご登録のメールアドレスに内容確認メールをお送り致します。<br>
                弊社スタッフからのご連絡をお待ちください。</h3>
               <div class="app-complete-btn d-flex justify-content-center">
                   <a href="{{ route('top.index') }}" class="btn btn-app btn-goto-home d-flex align-items-center justify-content-center event-link">
                       <span class="ic-txt d-inline-block">トップに戻る</span>
                       <img
                           src="{{ url('/assets/img/user/ic_arrow_right.svg') }}"
                           class="ic-arrow ic-arrow-right"
                           alt=""
                       >
                   </a>
               </div>
           </div>
       </div>
   </div>
@endsection
