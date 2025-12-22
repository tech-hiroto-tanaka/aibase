@extends('layouts.system')

@section('content')
<desired-cost-edit :data="{{ json_encode([
    'urlUpdate' => route('system.desired-cost.update', $item->id),
    'urlBack' => route('system.desired-cost.index'),
    'item' => $item,
    'title' => $title,
]) }}"></desired-cost-edit>
@endsection
