<template>
  <div class="modal fade favorite-modal" id="favoriteModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0 d-block">
          <h4 class="modal-title text-center">
            これ以降の機能は会員登録後ご利用いただけます、
          </h4>
          <p class="modal-sub-title text-center">
            会員登録済みの方はログイン、まだの方は会員登録にお進みください。
          </p>
        </div>
        <div class="modal-body">
          <div class="favorite-body row">
            <div class="col-lg-6 car-body-col body-left">
              <div class="card-content text-center">
                <h3 class="modal-content-title">
                  すでに会員登録済みの方は<br />
                  こちらから
                </h3>
                <a href="" class="btn modal-btn btn-redirect-login">
                  <span class="btn-txt">ログイン</span>
                  <img src="/assets/img/user/ic_arrow_right_white.svg" alt="" />
                </a>
              </div>
            </div>
            <div class="col-lg-6 car-body-col body-right">
              <div class="card-content text-center">
                <h3 class="modal-content-title">
                  また会員登録がお済みでない方は<br />
                  こちらから
                </h3>
                <a href="/register" class="btn modal-btn">
                  <span class="btn-txt">会員登録する（無料）</span>
                  <img src="/assets/img/user/ic_arrow_right_white.svg" alt="" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>