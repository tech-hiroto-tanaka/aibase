@php
use App\Components\SearchQueryComponent;
@endphp
@extends('layouts.user')
@section('content')
<div class="favorite-content">
    <div class="container favorite-container">
      <h2 class="title text-center">閲覧履歴</h2>
      <div class="favorite-list-wrapper">
        @if (!$jobViewHistories->isEmpty())
        <div class="favorite-list">
            @foreach ($jobViewHistories as $item)
            <favorite :job="{{ json_encode($item) }}" :data="{{ json_encode([
                'genreMasters' => $genreMasters,
                'areaMasters' => $areaMasters,
                'skillWordMasters' => $skillWordMasters,
                'desiredUnitPriceMasters' => $desiredUnitPriceMasters,
                'featureMasters' => $featureMasters,
                'isReload' => true
            ]) }}"></favorite>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">
            <div class="group-paginate">
                {{ $jobViewHistories->appends(SearchQueryComponent::alterQuery($request))->links('pagination.user') }}
            </div>
        </div>
        @else
            <data-empty></data-empty>
        @endif
      </div>
    </div>
  </div>
@endsection
