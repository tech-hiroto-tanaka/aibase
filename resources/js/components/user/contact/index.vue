<template>
  <div class="page-contact container">
    <div class="page-title">お問い合わせ</div>
    <VeeForm
      as="div"
      v-slot="{ handleSubmit }"
      @invalid-submit="onInvalidSubmit"
    >
      <form
        method="POST"
        @submit="handleSubmit($event, onSubmit)"
        :action="data.urlStore"
        ref="formData"
        class="contact-form"
      >
        <input type="hidden" :value="csrfToken" name="_token" />
        <!--お名前 -->
        <div class="row justify-content-center mb-3">
          <hr />
          <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
            <div class="row">
              <span class="col-8 col-sm-9"> お名前</span>
              <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
            </div>
          </div>
          <div class="col-8 ps-0 pe-0">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <Field
                    name="hira_first_name"
                    v-model="model.hira_first_name"
                    rules="required|max:50"
                    placeholder="姓"
                    class="form-control"
                  />
                  <ErrorMessage class="error" name="hira_first_name" />
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <Field
                    name="hira_last_name"
                    v-model="model.hira_last_name"
                    rules="required|max:50"
                    placeholder="名"
                    class="form-control"
                  />
                  <ErrorMessage class="error" name="hira_last_name" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- フリガナ -->
        <div class="row justify-content-center mb-3">
          <hr />
          <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
            <div class="row">
              <span class="col-8 col-sm-9"> フリガナ</span>
              <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
            </div>
          </div>
          <div class="col-8 ps-0 pe-0">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <Field
                    name="kata_first_name"
                    v-model="model.kata_first_name"
                    rules="required|katakana|max:50"
                    placeholder="セイ"
                    class="form-control"
                  />
                  <ErrorMessage class="error" name="kata_first_name" />
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <Field
                    name="kata_last_name"
                    v-model="model.kata_last_name"
                    rules="required|katakana|max:50"
                    placeholder="メイ"
                    class="form-control"
                  />
                  <ErrorMessage class="error" name="kata_last_name" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--  メールアドレス -->
        <div class="row justify-content-center mb-3">
          <hr />
          <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
            <div class="row">
              <span class="col-8 col-sm-9"> メールアドレス</span>
              <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
            </div>
          </div>
          <div class="col-8 ps-0 pe-0">
            <div class="form-group">
              <Field
                name="contact_email"
                v-model="model.contact_email"
                rules="required|email|max:255"
                placeholder="taro@example.jp"
                class="form-control"
              />
              <ErrorMessage class="error" name="contact_email" />
            </div>
          </div>
        </div>

        <!--  確認用 メールアドレス -->
        <div class="row justify-content-center mb-3">
          <hr />
          <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
            <div class="row">
              <span class="col-8 col-sm-9"> 確認用 メールアドレス</span>
              <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
            </div>
          </div>
          <div class="col-8 ps-0 pe-0">
            <div class="form-group">
              <Field
                name="contact_email_confirmation"
                v-model="model.contact_email_confirmation"
                rules="required|confirmed:@contact_email"
                placeholder="taro@example.jp"
                class="form-control"
              />
              <ErrorMessage class="error" name="contact_email_confirmation" />
            </div>
          </div>
        </div>

        <!-- ご連絡先電話番号 -->
        <div class="row justify-content-center mb-3">
          <hr />
          <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
            <div class="row">
              <span class="col-8 col-sm-9"> ご連絡先電話番号</span>
              <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
            </div>
          </div>
          <div class="col-8 ps-0 pe-0">
            <div class="form-group">
              <Field
                name="contact_phone_number"
                v-model="model.contact_phone_number"
                rules="required|telephone"
                placeholder="000-0000-0000"
                class="form-control"
              />
              <ErrorMessage class="error" name="contact_phone_number" />
            </div>
          </div>
        </div>

        <!--  お問い合わせ内容 -->

        <div class="row justify-content-center mb-3">
          <hr />
          <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
            <div class="row">
              <span class="col-8 col-sm-9"> お問い合わせ内容</span>
              <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
            </div>
          </div>
          <div class="col-8 ps-0 pe-0">
            <div class="form-group">
              <Field
                as="textarea"
                name="contact_content"
                v-model="model.contact_content"
                rules="required|max:20000"
                class="form-control"
                rows="10"
              />
              <ErrorMessage class="error" name="contact_content" />
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-12 text-center">
            <div class="privacy-policy my-5 custom-radio event-link">
              <Field
                type="radio"
                name="policy"
                v-model="model.agree"
                value="1"
                id="policy"
                class="me-3"
              >
              </Field>
              <label
                @click="openTab(data.openTabPolicy)"
                for="policy"
                class="text-decoration-underline contact-txt lh-20"
                >プライバシーポリシーに同意する</label
              >
              <br />
              <ErrorMessage class="error" name="policy" />
            </div>
            <button
              :disabled="!model.agree"
              v-bind:class="{ active: model.agree }"
              class="btn-form-submit event-link"
              type="submit"
            >
              同意して送信
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="14"
                height="14"
                fill="currentColor"
                class="bi bi-arrow-right"
                viewBox="0 0 16 16"
              >
                <path
                  fill-rule="evenodd"
                  d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"
                />
              </svg>
            </button>
          </div>
        </div>
      </form>
    </VeeForm>
    <loader :flag-show="flagShowLoader"></loader>
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
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
// import $ from "jquery";
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
          hira_last_name: {
            required: "名を入力してください。",
            max: "50文字を超えました。",
          },
          hira_first_name: {
            required: "姓を入力してください。",
            max: "50文字を超えました。",
          },
          kata_first_name: {
            required: "セイを入力してください",
            max: "50文字以内で入力してください",
            katakana: "全角カタカナで入力してください",
          },
          kata_last_name: {
            required: "メイを入力してください",
            max: "50文字以内で入力してください",
            katakana: "全角カタカナで入力してください",
          },
          contact_phone_number: {
            required: "電話番号を入力してください",
            max: "50文字以内で入力してください",
            telephone: "正しい電話番号をハイフンありでご記入ください",
          },
          contact_email: {
            required: "メールアドレスを入力してください",
            email: "メールアドレスを正確に入力してください",
            max: "メールアドレスは255文字以内で入力してください",
          },
          contact_email_confirmation: {
            required: "確認用メールアドレスを入力してください",
            confirmed: "メールアドレスが一致しません",
          },
          contact_content: {
            required: "お問い合わせ内容を入力してください",
            max: "本文は20,000文字以内で入力してください",
          },
          policy: {
            required: "プライバシーポリシーに同意してください",
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
      showOption: false,
      flagShowLoader: false,
      model: {
        hira_first_name: "",
        hira_first_name: "",
        kata_first_name: "",
        kata_last_name: "",
        contact_phone_number: "",
        contact_email: "",
        contact_email_confirmation: "",
        contact_content: "",
        urlContactStore: this.data.urlContactStore,
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
    openTab(href) {
      window.open(href);
    },
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
      this.$refs.formData.submit();
    },
  },
};
</script>
