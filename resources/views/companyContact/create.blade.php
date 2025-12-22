@extends('layouts.user')

@section('content')
    <company-contact-create :data="{{ json_encode([
    'areas' => $areas,
    'openTabPolicy' => route('privacy.index'),
    'urlCompanyContactStore' => route('company-contact.store')
]) }}">
    </company-contact-create>
@endsection
