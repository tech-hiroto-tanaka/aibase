@extends('layouts.user')

@section('content')
<application :data="{{ json_encode([
    'jobInfo' => $jobInfo,
    'dataAddress' => $dataAddress,
    'featureTxt' => $featureTxt,
    'areaMasters' => $areaMasters,
    'skillWordMasters' => $skillWordMasters,
    'urlRegisterJob' => route('user.application.update', $jobInfo->id)
]) }}"></application>
@endsection
