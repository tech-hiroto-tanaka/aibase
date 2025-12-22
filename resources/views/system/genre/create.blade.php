@extends('layouts.system')

@section('content')
<genre-create :data="{{ json_encode([
    'urlStore' => route('system.genre.store'),
    'urlBack' => route('system.genre.index'),
    'title' => $title,
    'order' => $order + 1
]) }}"></genre-create>
@endsection
