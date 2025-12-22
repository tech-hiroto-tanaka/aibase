@php
use App\Enums\Gender;
use App\Enums\DesiredWorkType;
@endphp

@extends('layouts.system')

@section('content')
    <user-edit
        :data="{{ json_encode([
            'urlUpdate' => route('system.user.update', $user->id),
            'urlCheckEmail' => route('system.user.checkEmail'),
            'user' => $user,
            'urlBack' => session()->get('system.user.list')[0] ?? route('system.user.index'),
            'gender' => Gender::parseArray(),
            'title' => $title,
            'desiredWorkType' => DesiredWorkType::parseArray(),
            'areas' => $areas->where('id', '!=', 1),
        ]) }}">
    </user-edit>
@endsection
