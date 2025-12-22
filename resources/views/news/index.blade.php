@php
use App\Components\SearchQueryComponent;
use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.user')

@section('content')
<div class="container bg-white py-5">
    <h2 class="text-center mb-5 title-news">お知らせ</h2>
    @if (!$news->isEmpty())
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="top-news-list">
          <div class="table-responsive">
            <table class="table table-news">
              <tbody>
                  @foreach ($news as $new)
                    <tr class="{{ Auth::guard('user')->check() && !$new->userNew ? 'unread' : '' }}">
                        <td><a href="{{route('news.show', $new->id)}}" class="time">{{ $new->publish_start_date_format_1 }}</a></td>
                        <td>
                        <span class="btn-news">お知らせ</span>
                        </td>
                        <td class="break-all" style="width: 50%"><a href="{{route('news.show', $new->id)}}">{{ $new->news_title }}</a></td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5">
                <div class="group-paginate">
                    {{ $news->appends(SearchQueryComponent::alterQuery($request))->links('pagination.user') }}
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @else
    <data-empty></data-empty>
    @endif
</div>
@endsection


