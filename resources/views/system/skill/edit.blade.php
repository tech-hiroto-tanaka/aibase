@extends('layouts.system')

@section('content')
<skill-edit :data="{{ json_encode([
    'urlUpdate' => route('system.skill.update', $item->id),
    'urlBack' => route('system.skill.index'),
    'item' => $item,
    'title' => $title,
]) }}"></skill-edit>
@endsection
