@extends('layouts.adminLogin')

@section('content')
<forgot-password-success
    :login-url="{{json_encode($loginUrl)}}"
></forgot-password-success>
@endsection
