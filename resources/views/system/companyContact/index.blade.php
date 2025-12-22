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
                            <label>会社の問い合わせ一覧</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('system.company-contact.index') }}" class="form-inline">
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
                            @if (!$companyContacts->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                                           :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $companyContacts->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                    <tr>
                                        <th class="w-120">
                                            @sortablelink('company_name', '会社名')
                                        </th>
                                        <th class="w-120">
                                            @sortablelink('department_name', '部署名')
                                        </th>
                                        <th class="w-120">
                                            @sortablelink('contact_phone_number', '電話番号')
                                        </th>
                                        <th class="w-120">
                                            @sortablelink('contact_email', 'メールアドレス')
                                        </th>
                                        <th class="w-120">
                                            @sortablelink('area_id', 'ご希望のエリア')
                                        </th>
                                        <th class="w-120">
                                            @sortablelink('contact_type', 'ステータス')
                                        </th>
                                        <th class="w-100">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($companyContacts as $companyContact)
                                        <tr class="{{ $companyContact->is_read ? '' : 'unread' }}">
                                            <td>
                                                {{ $companyContact->company_name }}
                                            </td>
                                            <td>
                                                {{ $companyContact->department_name }}
                                            </td>
                                            <td>
                                                {{ $companyContact->contact_phone_number }}
                                            </td>
                                            <td>
                                                <a href="{{ $companyContact->contact_email }}">{{ $companyContact->contact_email }}</a>
                                            </td>
                                            <td>
                                                {{ $companyContact->area ? $companyContact->area->area_name : '' }}
                                            </td>
                                            <td>
                                                {{ \App\Enums\ContactType::getDescription($companyContact->contact_type) }}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" id="action" type="button" data-coreui-toggle="dropdown" aria-expanded="false">操作選択</button>
                                                    <ul class="dropdown-menu" aria-labelledby="action">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('system.company-contact.show', $companyContact->id) }}"
                                                               class="dropdown-item">
                                                                <i class="fa fa-eye"></i>確認・編集
                                                            </a>
                                                        </li>
                                                        <li class="dropdown-divider"></li>
                                                        <li>
                                                            <btn-delete-confirm
                                                                :message-confirm="{{ json_encode('このお問い合わせを削除しますか？') }}"
                                                                :delete-action="{{ json_encode(route('system.company-contact.destroy', $companyContact->id)) }}">
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
                                    {{ $companyContacts->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
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
