@extends('layouts.system')

@section('content')
    <job-contact-detail
        :data="{{ json_encode([
            'urlUpdate' => route('system.job-contact.update', $jobContact->id),
            'jobContact' => $jobContact,
            'areaMasters' => $areaMasters,
            'skillWordMasters' => $skillWordMasters,
            'contactTypes' => $contactTypes,
            'urlBack' => session()->get('system.job-contact.list')[0] ?? route('system.job-contact.index')
        ]) }}">
    </job-contact-detail>
@endsection
