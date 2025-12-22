<template>
  <div class="container">
    <div class="fade-in page-login">
      <div class="row justify-content-center vh-100 align-center">
        <div class="col-md-8 col-lg-6 w-login">
          <VeeForm
              as="div"
              v-slot="{ handleSubmit }"
              @invalid-submit="onInvalidSubmit"
          >
            <form
                method="POST"
                @submit="handleSubmit($event, onSubmit)"
                :action="data.action"
                ref="formLogin"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
              <input
                  type="hidden"
                  :value="data.request.url_redirect"
                  name="url_redirect"
              />
              <div class="logo-register">
                <a :href="data.urlTop" title="home">
                  <img src="/assets/img/user/main_logo_white.svg" alt="logo"/>
                </a>
              </div>
              <div class="card form-login">
                <div class="card-body card-login">
                  <div class="row justify-content-center">
                    <div class="col-sm-10 mb-3 w-input">
                      <div class="form-group">
                        <label class="form-check-label pb-1 font-15">メールアドレス</label>
                        <Field
                            name="email"
                            v-model="data.email"
                            type="text"
                            class="form-control"
                            @keydown="changeInput"
                            rules="required|email"
                        />
                        <ErrorMessage class="error" name="email" />
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center mt-1">
                    <div class="col-sm-10 mb-3 w-input">
                      <div class="form-group">
                        <label class="form-check-label pb-1 font-15">パスワード</label>
                        <Field
                            class="form-control"
                            type="password"
                            autocomplete="new-password"
                            name="password"
                            @keydown="changeInput"
                            v-model="model.password"
                            rules="required|min:8"
                        />
                        <ErrorMessage class="error" name="password" />
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div
                        class="error text-center"
                        role="alert"
                        v-if="data.message"
                    >
                      {{ data.message }}
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-sm-10 p-l-20 text-center my-4">
                      <button class="btn btn-primary btn-login font-15" type="submit">
                        ログイン
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-sm-10 mb-3 text-center font-weight-normal">
                      <a href="/forgot-password" class="px-0 font-15 text-register"
                      >パスワードをお忘れですか？</a
                      >
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-sm-10 mb-3 text-center font-weight-normal font-15 lh-20">
                      新規登録の方は<a :href="data.urlRegister" class="px-0 text-register">こちら</a
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
import {Form as VeeForm, Field, ErrorMessage, configure, defineRule} from "vee-validate";
import {localize} from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import $ from "jquery";
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
          password: {
            required: "パスワードを入力してください",
            min: "パスワードは8文字以上で入力ください",
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
    onInvalidSubmit({ values, errors, results }) {
      let firstInputError = Object.entries(errors)[0][0];
      this.data.message = '';
      $("[name='" + firstInputError + "']").focus();
    },
    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formLogin.submit();
    },
    changeInput() {
      this.data.message = '';
    },
  },
};
</script>
