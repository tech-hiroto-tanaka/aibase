@extends('layouts.system')

@section('content')
<skill-create :data="{{ json_encode([
    'urlStore' => route('system.skill.store'),
    'urlBack' => route('system.skill.index'),
    'title' => $title,
    'order' => $order + 1
]) }}"></skill-create>
@endsection
