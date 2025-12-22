<footer class="footer">
    <div class="container footer-container">
         <div class="footer-wrapper">
             <div class="row">
                 <div class="col-12 col-xl-6">
                     <div class="logo">
                         <a href="{{ route('top.index') }}">
                             <img src="{{ url('/assets/img/user/main_logo_white.svg') }}" alt="logo white" width="187">
                         </a>
                     </div>
                     <div class="footer-link-container row">
                         <div class="col-6 col-sm">
                             <a href="{{ route('search.index') }}" class="footer-link">案件一覧</a>
                             <a href="{{ route('user.favorite.index') }}" class="footer-link">お気に入り</a>
                             <a href="{{ route('user.view-history.index') }}" class="footer-link">閲覧履歴</a>
                         </div>
                         <div class="col-6 col-sm">
                             <a href="{{ route('news.index') }}" class="footer-link">お知らせ</a>
                             {{-- <a href="{{ route('company-profile.index') }}" class="footer-link">会社概要</a> --}}
                             <a href="{{ route('contact.index')}}" class="footer-link">お問い合わせ</a>
                         </div>
                         <div class="col-12 col-sm">
                             <a href="{{ route('company-contact.index') }}" class="footer-link text-decoration-underline text-nowrap footer-link-end">エンジニアをお探しの企業様はこちら!!</a>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row footer-link-bottom-container">
                 <div class="col-md-6">
                     <div class="footer-link-bottom">
                         <a href="https://techedu.co.jp/" target="_blank" class="footer-link">運営会社</a>
                         <a href="{{ route('terms_of_service.index') }}" class="footer-link">利用規約</a>
                         <a href="{{ route('privacy.index') }}" class="footer-link">プライバシーポリシー </a>
                     </div>
                 </div>
                 <div class="col-md-6">
                    <div class="copyright text-center text-sm-end">
                        Copyright © {{ now()->year }} ATSUMARE  All Rights Reserved.
                    </div>
                 </div>
             </div>
         </div>
    </div>
</footer>
