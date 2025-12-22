@extends('layouts.guest')

@section('content')
<login :data="{{ json_encode([
    'request' => $request,
    'action' => route('login.store'),
    'urlTop' => route('top.index'),
    'urlRegister' => route('register.index'),
    'message' => $message ?? '',
    'email' => $email
]) }}"></login>
@endsection
