@extends('layouts.guest')

@section('content')
    <user-forgot-password :data="{{ json_encode([
    'action' => route('user.forgot-password.store'),
    'urlLogin' => route('login.index'),
    'urlTop' => route('top.index'),
    'message' => $message ?? '',
    'email' => $email
]) }}"></user-forgot-password>
@endsection
