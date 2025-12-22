@extends('layouts.system')
@section('content')
<job-create :data="{{ json_encode([
    'urlStore' => route('system.job.store'),
    'urlBack' => route('system.job.index'),
    'urlCheckCode' => route('system.job.checkCode'),
    'genreMasters' => $genreMasters,
    'areaMasters' => $areaMasters,
    'skillWordMasters' => $skillWordMasters,
    'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
    'featureMasters' => $featureMasters,
]) }}"></job-create>
@endsection
