<template>
  <div class="container">
    <div class="fade-in page-register">
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="formRegister">
            <div class="card">
              <div class="card-body card-done-register">
                <div class="row justify-content-center">
                  <div class="col-sm-12 text-center title-register mb-4">
                    <div class="logo-register">
                      <a :href="data.urlTop">
                        <img src="/assets/img/user/main_logo.png" alt="" />
                      </a>
                    </div>
                    <div class="thank-you mt-3">
                      本登録ありがとうございます。
                    </div>
                    <div class="my-4">
                      <img
                        style="width: 98px; height: 103px"
                        src="/images/write.png"
                        alt="tele"
                      />
                    </div>
                    <div
                      class="font-14 mt-3"
                      style="font-weight: 500; line-height: 25px"
                    >
                      登録が完了いたしました。<br />
                      引き続き案件情報の閲覧を行いたい方は「トップへ戻る」をクリック!!
                    </div>
                    <div
                      class="font-15 mt-5 mb-3"
                      style="font-weight: 500; line-height: 20px"
                    >
                      <a
                        class="
                          text-decoration-underline
                          btn-find-engineer
                          txt-user-link
                          event-link
                        "
                        :href="data.urlTop"
                        >トップへ戻る</a
                      >
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
