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
                    <div class="card">
                        <div class="card-header">
                            <label>{{ $title }}</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('system.mail-template.index') }}" class="form-inline">
                                            <div>
                                                <input name="search_input" class="form-control" placeholder="検索"
                                                    value="{{ $request->search_input }}" autocomplete="off" type="control"
                                                    id="search_input">
                                                <button type="submit" class="btn btn-primary w-100"><i
                                                        class="fa fa-search"></i> &nbsp; 検索</button>
                                            </div>
                                            <a href="{{ route('system.mail-template.create') }}"
                                                class="btn btn-primary btn-action-create">
                                                <i class="fa fa-plus"></i>新規登録
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (!$templates->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                            :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $templates->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th><input type="checkbox" class="check-all-delete"></th>
                                            <th style="width:50%">@sortablelink('mail_name', 'テンプレート名')</th>
                                            <th>@sortablelink('mail_subject', '件名')</th>
                                            <th class="w-100"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($templates as $item)
                                            <tr>
                                                <td><input type="checkbox" class="check-item-delete" data-id="{{ $item->id }}">
                                                <td>{{ $item->mail_name }}</td>
                                                <td>{{ $item->mail_subject }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" id="action"
                                                            type="button" data-coreui-toggle="dropdown"
                                                            aria-expanded="false">操作選択</button>
                                                        <ul class="dropdown-menu" aria-labelledby="action">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('system.mail-template.edit', $item->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fa fa-eye"></i>確認・編集
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <btn-delete-confirm
                                                                    :message-confirm="{{ json_encode('このメールテンプレートを削除しますか？') }}"
                                                                    :delete-action="{{ json_encode(route('system.mail-template.destroy', $item->id)) }}">
                                                                </btn-delete-confirm>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <btn-delete-multi :message-confirm="{{ json_encode('このメールテンプレートを削除しますか？') }}"
                                            :delete-action="{{ json_encode(route('system.mail-template.delete-multi')) }}">
                                        </btn-delete-multi>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $templates->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
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
