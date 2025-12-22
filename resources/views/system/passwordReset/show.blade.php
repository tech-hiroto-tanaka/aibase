@extends('layouts.adminLogin')

@section('content')
<password-reset
  :data="{{ json_encode([
    'urlUpdate' => route('system.password_reset.update', $token),
    'loginUrl' => route('system.login.index')
  ]) }}"
></password-reset>
@endsection
