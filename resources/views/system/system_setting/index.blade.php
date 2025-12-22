@extends('layouts.system')
@section('content')
    <system-setting :data="{{ json_encode([
    'urlStore' => route('system.system-setting.store'),
    'systemSettingInfo' => $systemSettingInfo ? $systemSettingInfo : [],
    'urlBack' => session()->get('system.system-setting.list')[0] ?? route('system.system-setting.index')
]) }}"></system-setting>
@endsection
