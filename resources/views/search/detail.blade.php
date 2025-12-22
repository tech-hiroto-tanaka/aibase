@php
    use App\Components\SearchQueryComponent;
@endphp
@extends('layouts.user')

@section('content')
    <div class="container search-detail-container">
        <div class="bg-white">
            <div class="row">
                <search :data="{{ json_encode([
                'genreMasters' => $genreMasters,
                'areaMasters' => $areaMasters,
                'skillWordMasters' => $skillWordMasters,
                'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
                'featureMasters' => $featureMasters,
                'request' => $request,
                'totalJob' => $jobResults->total()
            ]) }}">
                </search>
                <div class="col-md-8 search-right">
                    <div class="search-detail-content">
                        @php
                            $tags = [];
                            if (isset($request['genres'])) {
                                foreach ($request['genres'] as $key => $value) {
                                    $tag = $genreMasters->where('id', $value)->first();
                                    if ($tag) {
                                        $tags[] = $tag->genre_name;
                                    }
                                }
                            }
                            if (isset($request['areas'])) {
                                foreach ($request['areas'] as $key => $value) {
                                    $tag = $areaMasters->where('id', $value)->first();
                                    if ($tag) {
                                        $tags[] = $tag->area_name;
                                    }
                                }
                            }
                            if (isset($request['prefectures'])) {
                                foreach ($request['prefectures'] as $key => $value) {
                                    $tag = $prefectureMasters->where('id', $value)->first();
                                    if ($tag) {
                                        $tags[] = $tag->prefecture_name;
                                    }
                                }
                            }
                            if (isset($request['skills'])) {
                                foreach ($request['skills'] as $key => $value) {
                                    $tag = $skillWordMasters->where('id', $value)->first();
                                    if ($tag) {
                                        $tags[] = $tag->skill_name;
                                    }
                                }
                            }
                            if (isset($request['desiredCosts'])) {
                                foreach ($request['desiredCosts'] as $key => $value) {
                                    $tag = $desiredUnitPriceMasters->where('id', $value)->first();
                                    if ($tag) {
                                        $tags[] = $tag->desired_cost_name;
                                    }
                                }
                            }
                            if (isset($request['features'])) {
                                foreach ($request['features'] as $key => $value) {
                                    $tag = $featureMasters->where('id', $value)->first();
                                    if ($tag) {
                                        $tags[] = $tag->feature_name;
                                    }
                                }
                            }
                            if (isset($request['typeOfJobs'])) {
                                foreach ($request['typeOfJobs'] as $key => $value) {
                                    $tags[] = $value ? '派遣' : '共同受注';
                                }
                            }
                        @endphp
                        <job-info :data="{{ json_encode([
                            'tags' => $tags,
                            'jobInfo' => $jobInfo,
                            'featureTxt' => $featureTxt,
                            'areaMasters' => $areaMasters,
                            'dataAddress' => $dataAddress,
                            'skillWordMasters' => $skillWordMasters,
                        ]) }}"></job-info>
                        <div class="s-detail-footer">
                            <div class="application-btn text-center">
                                <div class="btn-apply-container text-center">
                                    <a href="{{route('user.application.show', $jobInfo->id)}}" class="btn btn-app btn-apply d-inline-flex align-items-center justify-content-center event-link">
                                        <span class="btn-txt d-inline-block">この案件に申し込む</span>
                                        <img
                                            src="{{ url('/assets/img/user/ic_arrow_right_white.svg') }}"
                                            class="ic-arrow ic-arrow-right"
                                            alt=""
                                        >
                                    </a>
                                </div>
                                <a href="{{ route('search.index', $request) }}" class="btn btn-back text-decoration-underline event-link">一覧へ戻る</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-suggest pt-5">
        <job-slider
            :txt-config="{{ json_encode(['h2' => 'おすすめ案件']) }}"
            :data="{{ json_encode([
            'jobNews' => $jobNews,
            'genreMasters' => $genreMasters,
            'areaMasters' => $areaMasters,
            'skillWordMasters' => $skillWordMasters,
            'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
            'featureMasters' => $featureMasters,
            'isDetail' => true
        ]) }}"
        ></job-slider>
    </div>
@endsection
