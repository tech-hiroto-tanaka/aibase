<template>
  <div class="container">
    <div class="fade-in page-login">
      <div class="row justify-content-center vh-100 align-center">
        <div class="col-md-8 col-lg-6 w-login">
          <VeeForm
              as="div"
              v-slot="{ handleSubmit }"
          >
            <form
                method="POST"
                @submit="handleSubmit($event, onSubmit)"
                :action="data.action"
                ref="formForgotPassword"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
              <div class="logo-register">
                <a :href="data.urlTop" title="home">
                  <img src="/assets/img/user/main_logo_white.svg" alt="logo"/>
                </a>
              </div>
              <div class="card form-login">
                <div class="card-body card-login">
                  <div class="row justify-content-center">
                    <h3 class="text-center mb-3 title-fgpw">パスワード再発行申請</h3>
                    <div class="col-sm-10 mb-3 w-input">
                      <div class="form-group">
                        <label class="form-check-label pb-1 font-15">パスワード再設定のURLを記載したメールを送信します。メールアドレスを入力し、送信ボタンを押してください。</label>
                        <Field
                            name="email"
                            type="text"
                            rules="required|email"
                            class="form-control"
                            v-model="data.email"
                        />
                        <ErrorMessage class="error" name="email" />
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-sm-10 p-l-20 text-center my-4">
                      <button class="btn btn-primary btn-login font-15" type="submit">
                        送信する
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-sm-10 mb-3 text-center font-weight-normal">
                      <a :href="data.urlLogin" class="px-0 font-15 text-register"
                      >ログイン画面へ</a
                      ><br />
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </VeeForm>
        </div>
      </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
  <div class="background-over">
  </div>
</template>

<script>
import Loader from "../../common/loader.vue";
import {
  Form as VeeForm,
  Field,
  ErrorMessage,
  defineRule,
  configure,
} from "vee-validate";
import * as rules from "@vee-validate/rules";
import {localize} from "@vee-validate/i18n";

export default {
  setup() {
    Object.keys(rules).forEach((rule) => {
      if (rule != "default") {
        defineRule(rule, rules[rule]);
      }
    });
  },
  created: function () {
    let messError = {
      en: {
        fields: {
          email: {
            required: "メールアドレスを入力してください",
            email: "メールアドレス形式が正しくありません",
          },
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });
  },
  data() {
    return {
      flagShowLoader: false,
      model: {
        email: ''
      },
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
    };
  },
  mounted() {},
  props: ["data"],
  components: {
    Loader,
    VeeForm,
    Field,
    ErrorMessage,
  },
  methods: {
    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formForgotPassword.submit();
    },
  },
};
</script>
