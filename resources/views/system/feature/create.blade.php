@extends('layouts.system')

@section('content')
<feature-create :data="{{ json_encode([
    'urlStore' => route('system.feature.store'),
    'urlBack' => route('system.genre.index'),
    'title' => $title,
    'order' => $order + 1
]) }}"></area-create>
@endsection
