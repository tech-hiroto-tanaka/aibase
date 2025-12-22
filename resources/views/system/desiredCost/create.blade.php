@extends('layouts.system')

@section('content')
<desired-cost-create :data="{{ json_encode([
    'urlStore' => route('system.desired-cost.store'),
    'urlBack' => route('system.desired-cost.index'),
    'title' => $title,
    'order' => $order + 1
]) }}"></desired-cost-create>
@endsection
