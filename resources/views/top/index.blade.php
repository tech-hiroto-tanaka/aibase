@php
use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.user')

@section('content')
    <top :data="{{ json_encode([
        'jobNews' => $jobNews,
        'topNews' => $topNews,
        'genreMasters' => $genreMasters,
        'areaMasters' => $areaMasters,
        'skillWordMasters' => $skillWordMasters,
        'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
        'featureMasters' => $featureMasters,
        'urlSearch' => route('search.store'),
        'isAuth' => Auth::guard('user')->check()
    ]) }}">
    </top>
@endsection
<style>
    .footer {
        padding-bottom: 100px;
    }
</style>
