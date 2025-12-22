@extends('layouts.system')

@section('content')
<new-edit :data="{{ json_encode([
    'urlUpdate' => route('system.news.update', $new->id),
    // 'urlCheckEmail' => route('admin.user.checkEmail'),
    'news' => $new,
    'title' => $title,
    'urlBack' => route('system.news.index')
]) }}"></new-edit>
@endsection
