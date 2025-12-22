@php
use App\Enums\Gender;
use App\Enums\DesiredWorkType;
@endphp

@extends('layouts.system')

@section('content')
    <user-create
        :data="{{ json_encode([
            'urlStore' => route('system.user.store'),
            'urlCheckEmail' => route('system.user.checkEmail'),
            'urlBack' => session()->get('system.user.list')[0] ?? route('system.user.index'),
            'gender' => Gender::parseArray(),
            'title' => $title,
            'desiredWorkType' => DesiredWorkType::parseArray(),
            'areas' => $areas->where('id', '!=', 1),
        ]) }}">
    </user-create>
@endsection
