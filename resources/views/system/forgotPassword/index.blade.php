@extends('layouts.adminLogin')

@section('content')
<forgot-password
    :data="{{ json_encode([
        'loginUrl' => route('system.login.index'),
        'storeUrl' => route('system.forgot_password.store')
    ]) }}"
></forgot-password>
@endsection
