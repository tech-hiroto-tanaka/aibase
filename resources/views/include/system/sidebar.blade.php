@php
$routeName = \Route::currentRouteName();
use App\Enums\ItemType;
$routeNew = [
    'system.news.index',
    'system.news.create',
    'system.news.store',
    'system.news.show',
    'system.news.edit',
    'system.news.update'];
$routeJob = [
    'system.job.index',
    'system.job.create',
    'system.job.store',
    'system.job.show',
    'system.job.edit',
    'system.job.update'
];
$routeContact = [
    'system.contact.index',
    'system.contact.create',
    'system.contact.store',
    'system.contact.show',
    'system.contact.edit',
    'system.contact.update'
];
$routeCompanyContact = [
    'system.company-contact.index',
    'system.company-contact.create',
    'system.company-contact.store',
    'system.company-contact.show',
    'system.company-contact.edit',
    'system.company-contact.update'
];
$routeUser = [
    'system.user.index',
    'system.user.create',
    'system.user.store',
    'system.user.show',
    'system.user.edit',
    'system.user.update'
];
$routeJobContact = ['system.job-contact.index', 'system.job-contact.show'];

$routeGenre = ['system.genre.index', 'system.genre.create', 'system.genre.update', 'system.genre.store', 'system.genre.edit'];
$routeArea = ['system.area.index', 'system.area.create', 'system.area.update', 'system.area.store', 'system.area.edit'];
$routeSkill = ['system.skill.index', 'system.skill.create', 'system.skill.update', 'system.skill.store', 'system.skill.edit'];
$routeDesiredCost = ['system.desired-cost.index', 'system.desired-cost.create', 'system.desired-cost.update', 'system.desired-cost.store', 'system.desired-cost.edit'];
$routeFeature = ['system.feature.index', 'system.feature.create', 'system.feature.update', 'system.feature.store', 'system.feature.edit'];

$routeMailTemplate = [
    'system.mail-template.index',
    'system.mail-template.create',
    'system.mail-template.store',
    'system.mail-template.show',
    'system.mail-template.edit',
    'system.mail-template.update',
];
$routeMailSchedule = [
    'system.mail-schedule.index',
    'system.mail-schedule.create',
    'system.mail-schedule.store',
    'system.mail-schedule.show',
    'system.mail-schedule.edit',
    'system.mail-schedule.update',
];
@endphp
<div class="sidebar sidebar-dark sidebar-fixed sidebar-lg-show" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" src="{{ url('/assets/img/user/main_logo_white.svg') }}" width="120" height="30">
        <img class="sidebar-brand-narrow" src="{{ url('/assets/img/user/main_logo_white.svg') }}" width="55" height="15">
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset">
                    <div class="simplebar-content-wrapper">
                        {{-- <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('system.dashboard.index') }}">
                                    <i class="nav-icon fa fa-home" aria-hidden="true"></i>
                                    ホーム
                                </a>
                            </li>
                        </div> --}}
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link {{ in_array($routeName, $routeJob) ? 'active' : '' }}"
                                    href="{{ route('system.job.index') }}">
                                    <i class="nav-icon fa fa-cubes" aria-hidden="true"></i>
                                    案件管理
                                </a>
                            </li>
                        </div>

                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link {{ in_array($routeName, $routeUser) ? 'active' : '' }}"
                                    href="{{ route('system.user.index') }}">
                                    <i class="nav-icon fa fa-user" aria-hidden="true"></i>
                                    ユーザー管理
                                </a>
                            </li>
                        </div>
                        <div class="simplebar-content">
                            @php
                                $isActive = in_array($routeName, $routeGenre) || in_array($routeName, $routeArea) || in_array($routeName, $routeSkill) || in_array($routeName, $routeDesiredCost) || in_array($routeName, $routeFeature);
                            @endphp
                            <li class="nav-group {{ $isActive ? 'show' : '' }}"
                                aria-expanded="false">
                                <a class="nav-link nav-group-toggle {{ $isActive ? 'active' : '' }}"
                                    href="#">
                                    <i class="nav-icon fa fa-cogs" aria-hidden="true"></i>
                                    アイテムマスタ
                                </a>
                                <ul class="nav-group-items">
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeGenre) ? 'active' : '' }}"
                                            href="{{ route('system.genre.index') }}">
                                            ジャンル
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeArea) ? 'active' : '' }}"
                                            href="{{ route('system.area.index') }}">
                                            エリア
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeSkill) ? 'active' : '' }}"
                                            href="{{ route('system.skill.index') }}">
                                            スキルワード
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeDesiredCost) ? 'active' : '' }}"
                                            href="{{ route('system.desired-cost.index') }}">
                                            希望単価
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeFeature) ? 'active' : '' }}"
                                            href="{{ route('system.feature.index') }}">
                                            特徴
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link {{ in_array($routeName, $routeNew) ? 'active' : '' }}"
                                    href="{{ route('system.news.index') }}">
                                    <i class="nav-icon fa fa-bell" aria-hidden="true"></i>
                                    お知らせ管理
                                </a>
                            </li>
                        </div>

                        <div class="simplebar-content">
                            <li class="nav-group {{ in_array($routeName, $routeJobContact) || in_array($routeName, $routeContact) || in_array($routeName, $routeCompanyContact) ? 'show' : '' }}"
                                aria-expanded="false">
                                <a class="nav-link nav-group-toggle" href="#">
                                    <i class="nav-icon fa fa-calendar-check-o" aria-hidden="true"></i>
                                    コンタクト管理
                                    @if ($countUnReadContact + $countUnReadCompanyContact + $countUnReadApplication)
                                    <span class="badge bg-danger badge-style badge-parent">{{ $countUnReadContact + $countUnReadCompanyContact + $countUnReadApplication }}</span>
                                    @endif
                                </a>
                                <ul class="nav-group-items">
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeJobContact) ? 'active' : '' }}"
                                            href="{{ route('system.job-contact.index') }}">
                                            求人応募
                                            @if ($countUnReadApplication)
                                                <span class="badge bg-danger badge-style">{{ $countUnReadApplication }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeContact) ? 'active' : '' }}"
                                            href="{{ route('system.contact.index') }}">
                                            ユーザーの問い合わせ
                                            @if ($countUnReadContact)
                                                <span class="badge bg-danger badge-style">{{ $countUnReadContact }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeCompanyContact) ? 'active' : '' }}"
                                            href="{{ route('system.company-contact.index') }}">
                                            会社の問い合わせ
                                            @if ($countUnReadCompanyContact)
                                                <span class="badge bg-danger badge-style">{{ $countUnReadCompanyContact }}</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>
                        <div class="simplebar-content">
                            <li class="nav-group {{ in_array($routeName, $routeMailTemplate) || in_array($routeName, $routeMailSchedule) ? 'show' : '' }}"
                                aria-expanded="false">
                                <a class="nav-link nav-group-toggle {{ in_array($routeName, $routeMailTemplate) || in_array($routeName, $routeMailSchedule) ? 'active' : '' }}"
                                    href="#">
                                    <i class="nav-icon fa fa-envelope" aria-hidden="true"></i>
                                    メール配信管理
                                </a>
                                <ul class="nav-group-items">
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeMailSchedule) ? 'active' : '' }}" href="{{ route('system.mail-schedule.index') }}">
                                            新規メール配信・履歴
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ in_array($routeName, $routeMailTemplate) ? 'active' : '' }}" href="{{ route('system.mail-template.index') }}">
                                            メールテンプレート
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('system.system-setting.index') }}">
                                    <i class="nav-icon fa fa-cogs" aria-hidden="true"></i>
                                    システム設定
                                </a>
                            </li>
                        </div>
                        {{-- <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link {{ in_array($routeName, $routeContact) ? 'active' : '' }}"
                                   href="{{ route('system.contact.index') }}">
                                    <i class="nav-icon fa fa-envelope-o" aria-hidden="true"></i>
                                    コンタクト管理
                                </a>
                            </li>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
