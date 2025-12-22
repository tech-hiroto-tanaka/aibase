@php
use App\Components\SearchQueryComponent;
use App\Enums\DesiredWorkType;
use App\Enums\Gender;
use Carbon\Carbon;
@endphp
@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="fade-in">
            <div class="row">
                <form action="{{ route('system.user.index') }}" id="form-search">
                <div class="col-sm-12">
                    <search :conditions="{{ json_encode($request->mail_condition) }}" :data="{{ json_encode([
                        'areas' => $areas,
                        'desiredWorkType' => DesiredWorkType::parseArray(),
                        'isSearch' => true,
                        'routeMail' => route('system.mail-schedule.create')
                    ]) }}"></search>
                    <div class="card">
                        <div class="card-header header-exits-btn">
                            <label>ユーザー一覧</label>
                            <div class="box-action">
                                <button
                                class="btn btn-primary btn-action-create btn-redirect">
                                検索結果にメールを配信
                            </button>
                            <a href="{{ route('system.user.export') }}"
                                class="btn btn-primary btn-action-create">
                                CSVダウンロード
                            </a>
                            </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <div class="form-inline">
                                            <div>
                                                <input name="search_input" class="form-control" placeholder="検索"
                                                    value="{{ $request->search_input }}" autocomplete="off" type="control"
                                                    id="search_input">
                                                <button type="submit" class="btn btn-primary w-100"><i
                                                        class="fa fa-search"></i> &nbsp; 検索</button>
                                            </div>

                                            <a href="{{ route('system.user.create') }}"
                                                class="btn btn-primary btn-action-create">
                                                <i class="fa fa-plus"></i>新規登録
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!$users->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                            :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $users->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>
                                                @sortablelink('name', '氏名')
                                            </th>
                                            <th>
                                                @sortablelink('name_kata', '氏名（カタ）')
                                            </th>
                                            <th class="w-120">
                                                @sortablelink('email', 'メールアドレス')
                                            </th>
                                            <th class="w-120">
                                                @sortablelink('gender', '性別')
                                            </th>
                                            <th class="w-160">
                                                @sortablelink('area.area_name', 'お住まいのエリア')
                                            </th>
                                            <th class="w-120">
                                                @sortablelink('created_at', '登録日時')
                                            </th>
                                            <th class="w-100">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    {{ $user->hira_first_name }}　{{ $user->hira_last_name }}
                                                </td>
                                                <td>
                                                    {{ $user->kata_first_name }}　{{ $user->kata_last_name }}
                                                </td>
                                                <td>
                                                    {{ $user->email }}
                                                </td>
                                                <td>
                                                    {{ Gender::getDescription($user->gender) }}
                                                </td>
                                                <td>
                                                    {{ $user->area ? $user->area->area_name : '' }}
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($user->created_at)->format('Y/m/d H:i:s') }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" id="action"
                                                            type="button" data-coreui-toggle="dropdown"
                                                            aria-expanded="false">操作選択</button>
                                                        <ul class="dropdown-menu" aria-labelledby="action">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('system.user.edit', $user->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fa fa-eye"></i>確認・編集
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <btn-delete-confirm
                                                                    :message-confirm="{{ json_encode('このユーザーを削除しますか？') }}"
                                                                    :delete-action="{{ json_encode(route('system.user.destroy', $user->id)) }}">
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
                                    {{ $users->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                </div>
                            @else
                                <data-empty></data-empty>
                            @endif
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
