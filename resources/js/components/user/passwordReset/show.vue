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
                ref="formPasswordReset"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
              <input type="hidden" name="_method" value="PUT" />
              <div class="logo-register">
                <a :href="data.urlTop" title="home">
                  <img src="/assets/img/user/main_logo_white.svg" alt="logo"/>
                </a>
              </div>
              <div class="card form-login">
                <div class="card-body card-login">
                  <div class="row justify-content-center">
                    <h3 class="text-center mb-3 title-fgpw">パスワードの再設定</h3>
                    <div class="col-sm-10 mb-3 w-input">
                      <div class="form-group">
                        <label class="form-check-label pb-1 font-15">パスワード <span class="text-danger">*</span></label>
                        <Field
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            v-model="model.password"
                            rules="required|max:32|min:8|password_rule"
                            class="form-control"
                            ref="password"
                        />
                        <ErrorMessage class="error" name="password" />
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-sm-10 mb-3 w-input">
                      <div class="form-group">
                        <label class="form-check-label pb-1 font-15">パスワード（確認用) <span class="text-danger">*</span></label>
                        <Field
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            v-model="model.password_confirmation"
                            rules="required|confirmed:@password"
                            class="form-control"
                        />
                        <ErrorMessage
                            class="error"
                            name="password_confirmation"
                        />
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
                    <div class="col-sm-10 mb-3 text-center font-weight-normal lh-20">
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
          password: {
            password_rule:
                "パスワードは半角英数字で、大文字、小文字、数字で入力してください",
            required: "パスワードを入力してください",
            max: "パスワードは32文字以内で入力してください",
            min: "パスワードは8文字以上で入力してください",
          },
          password_confirmation: {
            required: "パスワード（確認用）を入力してください",
            confirmed: "パスワード（確認用）が入力されたものと異なります。",
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
    onInvalidSubmit({ values, errors, results }) {
      let firstInputError = Object.entries(errors)[0][0];
      this.$el.querySelector("input[name=" + firstInputError + "]").focus();
      $("html, body").animate(
          {
            scrollTop:
                $("input[name=" + firstInputError + "]").offset().top - 150,
          },
          500
      );
    },
    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formPasswordReset.submit();
    },
  },
};
</script>
