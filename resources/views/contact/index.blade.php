@extends('layouts.user')

@section('content')
    <contact
        :data="{{ json_encode([
            'urlContactStore' => route('contact.store'),
            'openTabPolicy' => route('privacy.index'),
            'request' => $request,
            'message' => $message ?? '',
        ]) }}">
    </contact>
@endsection
