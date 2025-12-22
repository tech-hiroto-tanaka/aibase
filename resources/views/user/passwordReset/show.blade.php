@extends('layouts.guest')

@section('content')
    <user-password-reset :data="{{ json_encode([
    'urlUpdate' => route('user.password-reset.update', $token),
    'urlTop' => route('top.index'),
    'urlLogin' => route('login.index')
  ]) }}"
    ></user-password-reset>
@endsection
