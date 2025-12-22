@extends('layouts.system')

@section('content')
<genre-edit :data="{{ json_encode([
    'urlUpdate' => route('system.genre.update', $item->id),
    'item' => $item,
    'title' => $title,
]) }}"></genre-edit>
@endsection
