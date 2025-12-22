@extends('layouts.system')

@section('content')
<feature-edit :data="{{ json_encode([
    'urlUpdate' => route('system.feature.update', $item->id),
    'urlBack' => route('system.genre.index'),
    'item' => $item,
    'title' => $title,
]) }}"></feature-edit>
@endsection
