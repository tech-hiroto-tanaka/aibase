<!DOCTYPE html>

<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
        <title>【ATSUMARE】あなたにあった案件・求人が見つかる！繋がる！ITエンジニア人材のための案件・求人サイト！{{isset($title) ? (' | ' . $title) : ''}}</title>
        <meta name="keywords" content="ATSUMARE / エンジニア / IT / 人材 / 案件 / 求人 /  フリーランス / フルリモート / 高額">
        <meta name="description" content="フルリモート案件！継続安定！スキルアップ！高額案件！フリーランスのIT人材のための案件・求人サイト「ATSUMARE」をぜひご活用ください。案件情報を多数掲載中！契約・税務面も含め充実のサポート体制を実現！">
        <meta property="og:title" content="【ATSUMARE】あなたにあった案件・求人が見つかる！繋がる！ITエンジニア人材のための案件・求人サイト！" />
        <meta property="og:description" content="フルリモート案件！継続安定！スキルアップ！高額案件！フリーランスのIT人材のための案件・求人サイト「ATSUMARE」をぜひご活用ください。案件情報を多数掲載中！契約・税務面も含め充実のサポート体制を実現！" />
        <meta property="og:image" content="作成中" />
        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon.ico">
        <link rel="icon" type="image/png" sizes="192x192" href="/images/favicon.ico">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon.ico">
        <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon.ico">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.ico">
        <meta name="msapplication-TileImage" content="/images/favicon.ico">
        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
        <link href="{{ asset('css/userApp.css') }}" rel="stylesheet">
        <script src="{{ asset('js/userApp.js') }}" defer></script>

        @yield('css')
        <script>
            window.Laravel = {!!json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/'),
            ], JSON_UNESCAPED_UNICODE)!!};
        </script>
        @if (env('APP_ENV') == 'production')
        <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-54BJ63R');</script>
        <!-- End Google Tag Manager -->
        @endif
    </head>

    <body class="c-app">
        @if (env('APP_ENV') == 'production')
        <!-- Google Tag Manager (noscript) -->
            <noscript>
                <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-54BJ63R" height="0" width="0" style="display:none;visibility:hidden"></iframe>
            </noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif
        <div id="app">
            <div class="c-wrapper">
                <div class="c-body">
                    <main class="c-main">
                        @yield('content')
                    </main>
                </div>
            </div>
            @if (session()->get('Message.flash'))
                <popup-alert :data="{{json_encode(session()->get('Message.flash')[0])}}"></popup-alert>
            @endif
            @php
                session()->forget('Message.flash');
            @endphp
        </div>
        <div class="loading-div hidden">
            <div class="loader-img"></div>
        </div>
        @yield('javascript')
    </body>
</html>
