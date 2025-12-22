@php
use App\Components\SearchQueryComponent;
@endphp
@extends('layouts.user')

@section('content')
<div class="container">
    <div class="bg-white">
        <div class="row">
            <search :data="{{ json_encode([
                'genreMasters' => $genreMasters,
                'areaMasters' => $areaMasters,
                'skillWordMasters' => $skillWordMasters,
                'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
                'featureMasters' => $featureMasters,
                'urlSearch' => route('search.store'),
                'request' => $request->all(),
                'totalJob' => $jobResults->total()
            ]) }}">
            </search>
            <div class="col-md-8 search-right py-sm-5 show-loaded">
                <div class="search-results p-4 pt-0">
                    <div class="d-flex align-items-center pb-3 search-result-title">
                        <h3 class="fw-bold flex-grow-1 mb-0 title-search-filter">一覧【検索結果】</h3>
                        <div class="search-filter-select">
                            <label for="search_order" class="label-search-order">
                                <select class="form-select" id="search_order">
                                    <option {{$request->sort == 'updated_at' ? 'selected' : ''}} value="updated_at">新着順</option>
                                    <option {{$request->sort == 'min_desired_costs' ? 'selected' : ''}} value="min_desired_costs">単価順</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="search-result-list py-4">
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
                        @if ($tags)
                        <div class="row tag-list">
                            @foreach ($tags as $tag)
                                <div class="tag-item">{{ $tag }}</div>
                            @endforeach
                        </div>
                        @endif
                        @if (!$jobResults->isEmpty())
                        <div class="row favorite-row">
                            @foreach ($jobResults as $item)
                            <favorite :job="{{ json_encode($item) }}" :data="{{ json_encode([
                                'genreMasters' => $genreMasters,
                                'areaMasters' => $areaMasters,
                                'skillWordMasters' => $skillWordMasters,
                                'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
                                'featureMasters' => $featureMasters,
                                'isSearch' => true
                            ]) }}"></favorite>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <div class="group-paginate">
                                {{ $jobResults->appends(SearchQueryComponent::alterQuery($request))->links('pagination.user') }}
                            </div>
                        </div>
                        @else
                            <data-empty></data-empty>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
