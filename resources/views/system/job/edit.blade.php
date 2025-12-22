@extends('layouts.system')
@section('content')
<job-create :data="{{ json_encode([
    'urlStore' => route('system.job.update', $jobInfo->id),
    'urlBack' => route('system.job.index'),
    'urlCheckCode' => route('system.job.checkCode'),
    'genreMasters' => $genreMasters,
    'areaMasters' => $areaMasters,
    'skillWordMasters' => $skillWordMasters,
    'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
    'featureMasters' => $featureMasters,
    'jobInfo' => $jobInfo,
    'genreMasterList' => collect($jobInfo->genres)->pluck('id')->values(),
    'areaMasterList' => collect($jobInfo->areas)->pluck('id')->values(),
    'prefectureMasterList' => collect($jobInfo->prefectures)->pluck('id')->values(),
    'skillWordMasterList' => collect($jobInfo->skills)->pluck('id')->values(),
    'desiredJobCostList' => collect($jobInfo->desired_costs)->pluck('id')->values(),
    'jobFeatureList' => collect($jobInfo->features)->pluck('id')->values(),
    'isEdit' => true
]) }}"></job-create>
@endsection
