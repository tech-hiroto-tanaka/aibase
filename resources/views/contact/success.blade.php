@extends('layouts.guest')

@section('content')
<contact-success :data="{{ json_encode([
    'urlTop' => route('top.index'),
    'urlLogin' => route('login.index'),
]) }}"></contact-success>
@endsection
