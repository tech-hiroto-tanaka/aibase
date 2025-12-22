@extends('layouts.system')

@section('content')
    <contact-edit :data="{{ json_encode([
    'urlUpdate' => route('system.contact.update', $contact->id),
    'contact' => $contact,
    'contactTypes' => $contactTypes,
    'urlBack' => session()->get('system.contact.list')[0] ?? route('system.contact.index')
]) }}"></contact-edit>
@endsection
