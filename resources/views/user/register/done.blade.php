@extends('layouts.guest')

@section('content')
<done-register :data="{{ json_encode([
    'request' => $request,
    'urlTop' => route('top.index'),
    'urlLogin' => route('login.index'),
    'message' => $message ?? '',
]) }}"></done-register>
@endsection
