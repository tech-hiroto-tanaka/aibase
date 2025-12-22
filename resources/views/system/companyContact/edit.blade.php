@extends('layouts.system')

@section('content')
    <company-contact-edit :data="{{ json_encode([
    'urlUpdate' => route('system.company-contact.update', $companyContact->id),
    'companyContact' => $companyContact,
    'contactTypes' => $contactTypes,
    'urlBack' => session()->get('system.company-contact.list')[0] ?? route('system.company-contact.index')
]) }}"></company-contact-edit>
@endsection
