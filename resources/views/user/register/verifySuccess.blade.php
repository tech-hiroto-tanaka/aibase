@extends('layouts.guest')

@section('content')
<verify-success :data="{{ json_encode([
    'urlTop' => route('top.index'),
    'urlLogin' => route('login.index'),
]) }}"></verify-success>
@endsection
