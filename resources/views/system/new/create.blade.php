@extends('layouts.system')

@section('content')
<new-create :data="{{ json_encode([
    'urlStore' => route('system.news.store'),
    'urlBack' => route('system.news.index'),
    'title' => $title,
]) }}"></new-create>
@endsection
