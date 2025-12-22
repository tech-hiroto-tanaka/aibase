<template>
  <div class="container">
    <div class="page-contact-success">
      <div class="page-contact-modal">
        <div class="card">
          <div class="card-body contact-complete-modal">
            <div class="col-sm-12 text-center title-register mb-4">
              <div class="logo-register">
                <a :href="data.urlTop" title="home">
                  <img
                    src="/assets/img/user/main_logo.png"
                    style="width: 161px; height: 20px"
                    alt=""
                  />
                </a>
              </div>
              <div
                class="thank-you mt-3"
                style="margin-bottom: 36px; font-size: 20px"
              >
                お問い合わせありがとうございます。
              </div>
              <div class="my-4">
                <img
                  src="/images/Path 2882.png"
                  style="width: 126px; height: 98px"
                />
              </div>
              <div class="font-14" style="font-weight: 100; margin-top: 44px">
                お問い合わせの送信が完了しました。
              </div>
              <div
                class="font-15"
                style="
                  font-weight: 400;
                  margin-top: 58px;
                  text-decoration: underline;
                "
              >
                <a :href="data.urlTop">トップへ戻る</a>
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
