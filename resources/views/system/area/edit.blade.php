@extends('layouts.system')

@section('content')
<area-edit :data="{{ json_encode([
    'urlUpdate' => route('system.area.update', $item->id),
    'urlBack' => route('system.area.index'),
    'item' => $item,
    'title' => $title,
    'areaSelect' => $areaSelect,
    'prefectures' => $prefectures,
]) }}"></area-edit>
@endsection
