@php
use App\Enums\Gender;
use App\Enums\DesiredWorkType;
if (isset($errors) && count($errors)) {
    // dd($errors);
}
@endphp

@extends('layouts.guest')

@section('content')
    <register
        :data="{{ json_encode([
            'request' => $request,
            'urlRegister' => route('user.register'),
            'urlTop' => route('top.index'),
            'urlLogin' => route('login.index'),
            'urlCheckEmail' => route('user.checkEmail'),
            'message' => $message ?? '',
            'gender' => Gender::parseArray(),
            'openTabPolicy' => route('privacy.index'),
            'desiredWorkType' => DesiredWorkType::parseArray(),
            'areas' => $areas,
        ]) }}">
    </register>
@endsection
