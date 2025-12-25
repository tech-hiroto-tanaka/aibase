@php
    use Illuminate\Support\Facades\Auth;
@endphp
<header class="header">
    <div class="container header-container">
        <div class="row align-items-center">
            <div class="col-6 col-sm-12 col-md-4 col-xl-6 header-left">
                <div class="logo">
                    <a href="{{ route('top.index') }}">
                        <img src="{{ url('/assets/img/user/logo_aibase.png') }}" alt="logo" width="187">
                    </a>
                </div>
            </div>
            <div class="col-6 col-sm-12 col-md-8 col-xl-6 header-right">
                <div class="d-none d-sm-flex align-items-center {{ Auth::guard('user')->check() ? 'justify-content-end' : 'justify-content-between' }}">
                    @if (Auth::guard('user')->check())
                        <a href="{{route('user.logout')}}" class="btn-login d-inline-flex align-items-center ele-logout event-link">
                            <span class="ic-login">
                                <img src="{{ url('/assets/img/user/icon_logout.svg') }}" alt="">
                            </span>
                            <span class="login-txt txt-user-link">ログアウト</span>
                        </a>
                        <a href="{{route('user.profile.index')}}" class="btn-login d-inline-flex align-items-center event-link">
                            <span class="ic-login">
                                <img src="{{ url('/assets/img/user/icon_user.svg') }}" alt="">
                            </span>
                            <span class="login-txt txt-user-link">マイページ</span>
                        </a>
                    @else
                        <a href="{{ route('company-contact.index') }}" class="text-decoration-underline btn-find-engineer txt-user-link event-link">エンジニアをお探しの企業様はこちら!!</a>
                        <a href="{{route('login.index')}}" class="btn-login d-inline-flex align-items-center event-link">
                            <span class="ic-login">
                                <img src="{{ url('/assets/img/user/icon_login.svg') }}" alt="">
                            </span>
                            <span class="login-txt txt-user-link">ログイン</span>
                        </a>
                        <a href="{{route('register.index')}}" class="btn-register txt-user-link event-link">無料で会員登録</a>
                    @endif
                </div>
                <div class="header-right-sp d-flex d-sm-none">
                    <a
                        href="#"
                        class="btn-open-search"
                        data-bs-toggle="modal"
                        data-bs-target="#searchModal"
                    >
                        <img src="{{ url('/assets/img/user/btn_sp_search.svg') }}" alt="案件検索">
                    </a>
                    <div class="navbar-container d-flex">
                        <div class="navbar-icon text-right">
                            <span class="ic-bar"></span>
                            <span class="ic-bar"></span>
                            <span class="ic-bar"></span>
                            <span class="txt-menu">MENU</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom d-none d-sm-block">
        <div class="header-bottom-link d-flex justify-content-center align-items-center">
            <a href="{{ route('search.index') }}" class="event-link">案件一覧</a>
            <a href="{{ route('user.favorite.index') }}" class="event-link">お気に入り</a>
            <a href="{{ route('user.view-history.index') }}" class="event-link">閲覧履歴</a>
            <a href="{{ route('news.index') }}" class="event-link">お知らせ
                @if (Auth::guard('user')->check() && $countNewUnRead)
                <span class="badge bg-danger badge-style badge-parent">{{ $countNewUnRead }}</span>
                @endif
            </a>
            {{-- <a href="{{ route('company-profile.index') }}" class="event-link">会社概要</a> --}}
            <a href="{{ route('contact.index')}}" class="event-link">お問い合わせ</a>
        </div>
    </div>
</header>
<div class="header-sidebar close-sidebar">
    <div class="header-sidebar-container">
        <div class="sidebar-header-link">
            <a href="{{ route('search.index') }}" class="sidebar-link">案件一覧</a>
            <a href="{{ route('user.favorite.index') }}" class="sidebar-link">お気に入り</a>
            <a href="{{ route('user.view-history.index') }}" class="sidebar-link">閲覧履歴</a>
            <a href="{{ route('news.index') }}" class="sidebar-link">お知らせ</a>
            {{-- <a href="{{ route('company-profile.index') }}" class="sidebar-link">会社概要</a> --}}
            <a href="{{ route('contact.index')}}" class="sidebar-link">お問い合わせ</a>
        </div>
        <div class="sp-login-register">
            @if (Auth::guard('user')->check())
            <a href="{{route('user.logout')}}" class="btn-login d-inline-flex align-items-center">
                <span class="login-txt txt-user-link">ログアウト</span>
            </a>
            <a href="{{route('user.profile.index')}}" class="btn-login d-inline-flex align-items-center">
                <span class="login-txt txt-user-link">マイページ</span>
            </a>
            @else
            <a href="{{ route('login.index') }}" class="btn-login d-inline-flex align-items-center">
                <span class="ic-login">
                    <img src="{{ url('/assets/img/user/icon_login_white.svg') }}" alt="">
                </span>
                <span class="login-txt txt-user-link">ログイン</span>
            </a>
            <a href="{{ route('register.index') }}" class="btn-register txt-user-link event-link">無料で会員登録</a>
            @endif
            <a href="{{ route('company-contact.index') }}" class="text-decoration-underline btn-find-engineer txt-user-link">エンジニアをお探しの企業様はこちら!!</a>
        </div>
    </div>
</div>
