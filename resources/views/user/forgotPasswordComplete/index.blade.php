@extends('layouts.guest')

@section('content')
    <user-forgot-password-success :data="{{ json_encode([
    'urlLogin' => route('login.index'),
    'urlTop' => route('top.index')
]) }}"></user-forgot-password-success>
@endsection

