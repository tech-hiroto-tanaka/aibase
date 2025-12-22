@php
use App\Enums\Gender;
use App\Enums\DesiredWorkType;
@endphp
@extends('layouts.user')

@section('content')
    <profile
        :data="{{ json_encode([
            'request' => $request,
            'urlUpdateProfile' => route('user.profile.update', $user->id),
            'urlCheckEmail' => route('user.checkEmail'),
            'message' => $message ?? '',
            'user' => $user,
            'gender' => Gender::parseArray(),
            'desiredWorkType' => DesiredWorkType::parseArray(),
            'areas' => $areas,
        ]) }}">
    </profile>
@endsection
