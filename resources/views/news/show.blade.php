@extends('layouts.user')

@section('content')
<div class="container">
    <div class="page-news">
        <div class="page-title">{{ $newInfo->news_title }}</div>
        <div class="page-desc">{!! nl2br(htmlentities($newInfo->news_content)) !!}</div>
        <button class="btn-form-submit back-news event-link">
            <a href="{{ route('news.index'); }}" title="一覧へ戻る">
                一覧へ戻る
                <svg xmlns="http://www.w3.org/2000/svg" width="10.16" height="5.535" viewBox="0 0 10.16 5.535">
                    <g id="Group_834" data-name="Group 834" transform="translate(-339.5 -478.327)">
                        <line id="Line_33" data-name="Line 33" x2="9" transform="translate(339.5 481.094)" fill="none" stroke="#000" stroke-width="1"/>
                        <path id="Path_2477" data-name="Path 2477" d="M3161.021,440.394l2.414-2.414,2.414,2.414" transform="translate(786.933 -2682.341) rotate(90)" fill="none" stroke="#000" stroke-width="1"/>
                    </g>
                </svg>
            </a>
        </button>
    </div>
</div>
@endsection
