@php
use App\Enums\DesiredWorkType;
@endphp
@extends('layouts.system')

@section('content')
    <mail-schedule
        :data="{{ json_encode([
            'schedule' => $schedule,
            'urlBack' => route('system.mail-schedule.index'),
            'urlSubmit' => route('system.mail-schedule.update', $schedule->id),
            'templates' => $templates,
            'mail_masters' => $mailMasters,
            'areas' => $areas,
            'title' => $title,
            'desiredWorkType' => DesiredWorkType::parseArray(),
            'isEdit' => true,
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS')
        ]) }}">
    </mail-schedule>
@endsection
