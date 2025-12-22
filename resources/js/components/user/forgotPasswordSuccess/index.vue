<template>
  <div class="container">
    <div class="fade-in page-login">
      <div class="row justify-content-center vh-100 align-center">
        <div class="col-md-8 col-lg-6 w-login">
          <div class="logo-register">
            <a :href="data.urlTop" title="home">
              <img src="/assets/img/user/main_logo_white.svg" alt="logo"/>
            </a>
          </div>
          <div class="card form-login">
            <div class="card-body card-login">
              <div class="row justify-content-center mb-4">
                <div class="col-sm-12 text-center title-login">
                  <h3 class="title-fg-pw-cpl">確認メールを送信致しました</h3>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-sm-12">
                  <div class="form-group text-center">
                    <label class="title-forgot-password text-center font-15 lh-20"
                    >入力されたメールアドレスに確認メールを送信いたしました。<br />
                      メールの手順に沿ってパスワードを変更してください
                    </label>
                  </div>
                </div>
              </div>
              <br/>
              <br/>
              <div class="row justify-content-center group-back-login">
                <div class="col-sm-12 p-l-20 text-center">
                  <a class="btn-link px-0 font-15 lh-20" :href="data.urlLogin">ログイン画面へ</a
                  ><br />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="background-over">
  </div>
</template>

<script>
export default {
  mounted() {},
  props: ["data"],
};
</script>
