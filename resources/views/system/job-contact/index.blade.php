@php
use App\Components\SearchQueryComponent;
use Carbon\Carbon;

@endphp
@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-search mb-2">
                        <div
                            class="card-header header-search {{ $request->job_code != '' || $request->job_name != '' || $request->email != '' ? 'show' : '' }}">
                            <label><i class="fa fa-search"></i> &nbsp; 検索</label>
                            <i class="fa fa-arrow-down" aria-hidden="true"></i>
                        </div>
                        <div class="card-body body-search text-center">
                            <form action="{{ route('system.job-contact.index') }}">
                                <div class="row mb-2">
                                    <label class="form-label col-sm-4 lbl-input">案件コード </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="job_code" value="{{ $request->job_code }}" />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="form-label col-sm-4 lbl-input"> 案件名 </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="job_name" value="{{ $request->job_name }}" />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="form-label col-sm-4 lbl-input">メールアドレス</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="email" value="{{ $request->email }}" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa fa-search"></i> &nbsp; 検索
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <label>求人応募 </label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('system.job-contact.index') }}" class="form-inline">
                                            <div>
                                                <input name="search_input" class="form-control" placeholder="検索"
                                                    value="{{ $request->search_input }}" autocomplete="off" type="control"
                                                    id="search_input">
                                                <button type="submit" class="btn btn-primary w-100"><i
                                                        class="fa fa-search"></i> &nbsp; 検索</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (!$jobContact->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                            :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $jobContact->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="w-80"> @sortablelink('user_email', 'メールアドレス')</th>
                                            <th class="w-80"> @sortablelink('job_code', '案件コード')</th>
                                            <th class="w-110"> @sortablelink('job_name', '案件名')</th>
                                            <th class="w-100m"> @sortablelink('start_date', '公開開始日')</th>
                                            <th class="w-100m"> @sortablelink('end_date', '公開終了日')</th>
                                            <th class="w-100m"> @sortablelink('status', 'ステータス')</th>
                                            <th class="w-100m"> @sortablelink('created_at', '登録時間')</th>
                                            <th class="w-100">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobContact as $item)
                                            <tr class="{{ $item->is_read ? '' : 'unread' }}">
                                                <td>
                                                    <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                                                </td>
                                                <td>
                                                    {{ $item->code }}
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($item->start_date)->format('Y/m/d H:i') }}
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($item->end_date)->format('Y/m/d H:i') }}
                                                </td>
                                                <td>
                                                    {{ \App\Enums\ContactType::getDescription($item->status) }}
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($item->created_at)->format('Y/m/d H:i') }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" id="action"
                                                            type="button" data-coreui-toggle="dropdown"
                                                            aria-expanded="false">操作選択</button>
                                                        <ul class="dropdown-menu" aria-labelledby="action">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('system.job-contact.show', $item->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fa fa-eye"></i>確認・編集
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <btn-delete-confirm
                                                                    :message-confirm="{{ json_encode('この問い合わせを削除しますか？') }}"
                                                                    :delete-action="{{ json_encode(route('system.job-contact.destroy', $item->id)) }}">
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
                                    {{ $jobContact->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
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
