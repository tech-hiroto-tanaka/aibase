<template>
  <div class="container">
    <div class="fade-in page-register">
      <div class="logo-register">
        <a :href="data.urlTop" title="home">
          <img src="/assets/img/user/main_logo_white.svg" alt="" />
        </a>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="formRegister">
            <div class="card">
              <div class="card-body card-done-register">
                <div class="row justify-content-center">
                  <div class="col-sm-12 text-center title-register mb-4">
                    <div class="title-done">新規会員登録</div>
                    <div class="thank-you mt-3">
                      仮登録ありがとうございます。
                    </div>
                    <div class="my-4">
                      <img src="/images/tele.png" alt="tele" />
                    </div>
                    <div class="font-14 mt-5">
                      ご登録のメールアドレスに確認メールをお送りしました。<br />
                      お届けしたメール内のURLをクリックして会員登録を続けてください。
                    </div>
                    <hr />
                    <div class="font-14 text-lg-start text-url-email">
                      ※メールに記載された登録URLの有効期限は24時間です。有効期限が切れた場合は再度メールアドレスの入力を行ってください。<br />
                      ※確認メールが届かない場合は迷惑メールフォルダに振り分けられていることもありますのでご確認ください。
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="background-over bg-done-register"></div>
</template>

<script>
export default {
  setup() {},
  created: function () {},
  data() {
    return {
      showOption: false,
      flagShowLoader: false,
      model: {},
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
    };
  },
  mounted() {},
  props: ["data"],
  components: {},
  methods: {},
};
</script>
