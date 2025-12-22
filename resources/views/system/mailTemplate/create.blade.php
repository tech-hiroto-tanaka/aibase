@php
use Carbon\Carbon;
@endphp
@extends('layouts.system')

@section('content')
    <mail-template
        :data="{{ json_encode([
            'item' => $item,
            'urlStore' => route('system.mail-template.store'),
            'urlBack' => route('system.mail-template.index'),
            'mail_masters' => $mailMasters,
            'name_layout' => '新規メールテンプレート作成'
        ]) }}">
    </mail-template>
@endsection
