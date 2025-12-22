@extends('layouts.system')

@section('content')
<area-create :data="{{ json_encode([
    'urlStore' => route('system.area.store'),
    'urlBack' => route('system.area.index'),
    'title' => $title,
    'areaSelect' => $areaSelect,
    'prefectures' => $prefectures,
    'order' => $order + 1
]) }}"></area-create>
@endsection
