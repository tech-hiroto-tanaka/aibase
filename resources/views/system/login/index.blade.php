@extends('layouts.adminLogin')

@section('content')
<login :data="{{ json_encode([
    'request' => $request,
    'urlForgotPass' => route('system.forgot_password.index'),
    'message' => $message ?? '',
]) }}"></login>
@endsection
