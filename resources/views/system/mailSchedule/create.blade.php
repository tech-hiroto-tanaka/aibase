@php
use App\Enums\DesiredWorkType;
@endphp
@extends('layouts.system')

@section('content')
    <mail-schedule
        :data="{{ json_encode([
            'urlSubmit' => route('system.mail-schedule.store'),
            'urlBack' => route('system.mail-schedule.index'),
            'urlCreateTemplate' => route('system.mail-template.index'),
            'templates' => $templates,
            'mail_masters' => $mailMasters,
            'request' => $request->all(),
            'areas' => $areas,
            'desiredWorkType' => DesiredWorkType::parseArray(),
            'title' => $title,
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS')
        ]) }}">
    </mail-schedule>
@endsection
