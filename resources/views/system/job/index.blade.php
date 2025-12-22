@php
use App\Components\SearchQueryComponent;
use App\Enums\PublishStatus;
use Carbon\Carbon;
@endphp
@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <label>案件一覧</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('system.job.index') }}" class="form-inline">
                                            <div>
                                                <input name="search_input" class="form-control" placeholder="検索" value="{{ $request->search_input }}">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fa fa-search"></i> &nbsp; 検索
                                                </button>
                                            </div>
                                            <a href="{{ route('system.job.create') }}" class="btn btn-primary btn-action-create">
                                                <i class="fa fa-plus"></i>新規登録
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (!$jobs->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                            :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $jobs->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="w-120">
                                                @sortablelink('job_code', '案件コード')
                                            </th>
                                            <th class="w-165">
                                                @sortablelink('job_name', '案件名')
                                            </th>
                                            <th class="w-120">
                                                @sortablelink('job_publish_start_date', '公開開始日')
                                            </th>
                                            <th class="w-120">
                                                @sortablelink('job_publish_end_date', '公開終了日')
                                            </th>
                                            <th class="w-100">
                                                @sortablelink('job_publish_status', '公開設定')
                                            </th>
                                            <th class="w-100">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobs as $job)
                                            <tr>
                                                <td>
                                                    {{ $job->job_code }}
                                                </td>
                                                <td>
                                                    {{ $job->job_name }}
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($job->job_publish_start_date)->format('Y/m/d') }}
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($job->job_publish_end_date)->format('Y/m/d') }}
                                                </td>
                                                <td>
                                                    {{ PublishStatus::getDescription($job->job_publish_status) }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" id="action" type="button" data-coreui-toggle="dropdown" aria-expanded="false">操作選択</button>
                                                        <ul class="dropdown-menu" aria-labelledby="action">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('system.job.edit', $job->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fa fa-eye"></i>確認・編集
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <btn-delete-confirm
                                                                    :message-confirm="{{ json_encode('この案件を削除しますか？') }}"
                                                                    :delete-action="{{ json_encode(route('system.job.destroy', $job->id)) }}">
                                                                </btn-delete-confirm>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="group-paginate">
                                    {{ $jobs->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
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
