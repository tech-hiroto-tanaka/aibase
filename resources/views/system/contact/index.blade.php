@php
use App\Components\SearchQueryComponent;
@endphp
@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <label>ユーザーの問い合わせ一覧</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('system.contact.index') }}" class="form-inline">
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
                            @if (!$contacts->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                            :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $contacts->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="w-13">
                                                @sortablelink('hira_first_name', '姓')
                                            </th>
                                            <th class="w-13">
                                                @sortablelink('hira_last_name', '名')
                                            </th>
                                            <th class="w-13">
                                                @sortablelink('kata_first_name', 'セイ')
                                            </th>
                                            <th class="w-13">
                                                @sortablelink('kata_last_name', 'メイ')
                                            </th>

                                            <th>
                                                @sortablelink('contact_phone_number', '電話番号')
                                            </th>
                                            <th>
                                                @sortablelink('contact_email', 'メールアドレス')
                                            </th>
                                            <th>
                                                @sortablelink('contact_type', 'ステータス')
                                            </th>
                                            <th class="w-100">
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr class="{{ $contact->is_read ? '' : 'unread' }}">
                                                <td>
                                                    {{ $contact->hira_first_name }}
                                                </td>
                                                <td>
                                                    {{ $contact->hira_last_name }}
                                                </td>
                                                <td>
                                                    {{ $contact->kata_first_name }}
                                                </td>
                                                <td>
                                                    {{ $contact->kata_last_name }}
                                                </td>
                                                <td>
                                                    {{ $contact->contact_phone_number }}
                                                </td>
                                                <td>
                                                    <a
                                                        href="mailto:{{ $contact->contact_email }}">{{ $contact->contact_email }}</a>
                                                </td>
                                                <td>
                                                    {{ \App\Enums\ContactType::getDescription($contact->contact_type) }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" id="action"
                                                            type="button" data-coreui-toggle="dropdown"
                                                            aria-expanded="false">操作選択</button>
                                                        <ul class="dropdown-menu" aria-labelledby="action">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('system.contact.show', $contact->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fa fa-eye"></i>確認・編集
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <btn-delete-confirm
                                                                    :message-confirm="{{ json_encode('このお問い合わせを削除しますか？') }}"
                                                                    :delete-action="{{ json_encode(route('system.contact.destroy', $contact->id)) }}">
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
                                    {{ $contacts->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
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
