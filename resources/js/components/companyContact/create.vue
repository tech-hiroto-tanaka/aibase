<template>
  <div class="container page-contact ">
                      <h4 class="page-title">お問い合わせ <br class="sp">（エンジニアをお探しの企業様専用）</h4>

          <VeeForm
              as="div"
              v-slot="{ handleSubmit }"
              :validation-schema="schema"
              @invalid-submit="onInvalidSubmit"
          >
            <form
                method="POST"
                @submit="handleSubmit($event, onSubmit)"
                :action="data.urlCompanyContactStore"
                ref="formData"
                class="contact-form"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
                  <div class="row justify-content-center mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9"> 会社名</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">

                          <div class="form-group">
                            <Field
                                as="input"
                                name="company_name"
                                v-model="model.company_name"
                                rules="required|max:255"
                                placeholder="例）株式会社ATSUMARE"
                                class="form-control"
                            />
                            <ErrorMessage class="error" name="company_name" />
                          </div>
                        
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9">部署名</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required black">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">
                      
                          <div class="form-group">
                            <Field
                                as="input"
                                name="department_name"
                                v-model="model.department_name"
                                placeholder="例）営業部"
                                rules="max:255"
                                class="form-control"
                            />
                            <ErrorMessage class="error" name="department_name" />
                          </div>
                        
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9">お名前</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <Field
                                as="input"
                                name="contact_hira_first_name"
                                v-model="model.contact_hira_first_name"
                                rules="required|max:50"
                                placeholder="姓"
                                class="form-control"
                            />
                            <ErrorMessage class="error" name="contact_hira_first_name" />
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <Field
                                as="input"
                                name="contact_hira_last_name"
                                v-model="model.contact_hira_last_name"
                                rules="required|max:50"
                                placeholder="名"
                                class="form-control"
                            />
                            <ErrorMessage class="error" name="contact_hira_last_name" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9">フリガナ</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <Field
                                as="input"
                                name="contact_kata_first_name"
                                v-model="model.contact_kata_first_name"
                                rules="required|katakana|max:50"
                                placeholder="セイ"
                                class="form-control"
                            />
                            <ErrorMessage class="error" name="contact_kata_first_name" />
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <Field
                                as="input"
                                name="contact_kata_last_name"
                                v-model="model.contact_kata_last_name"
                                rules="required|katakana|max:50"
                                placeholder="メイ"
                                class="form-control"
                            />
                            <ErrorMessage class="error" name="contact_kata_last_name" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9"> メールアドレス</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">
                      
                          <div class="form-group">
                            <Field
                                as="input"
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

                  <div class="row justify-content-center align-items-center mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9"> 確認用 <br/>
                        メールアドレス</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">
                      <div class="form-group">
                        <Field
                            as="input"
                            name="contact_email_confirm"
                            v-model="model.contact_email_confirm"
                            rules="required|email|email_confirm|max:255"
                            placeholder="taro@example.jp"
                            class="form-control"
                        />
                        <ErrorMessage class="error" name="contact_email_confirm" />
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9"> ご連絡先電話番号</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">
                      <div class="form-group">
                        <Field
                            as="input"
                            name="contact_phone_number"
                            v-model="model.contact_phone_number"
                            rules="required|telephone|max:255"
                            placeholder="000-0000-00000"
                            class="form-control"
                        />
                        <ErrorMessage class="error" name="contact_phone_number" />
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center align-items-start mb-3">
                    <hr>
                    <div class="col-4 r-mb-1 contact-txt lh-20 d-lbl ps-0">
                      <div class="row">
                        <span class="col-8 col-sm-9"> ご希望のエリア</span>
                        <div class="col-4 col-sm-3 p-0"><span class="required">必須</span></div>
                      </div>
                    </div>
                    <div class="col-8 ps-0 pe-0">
                      <div class="form-group me-4 mb-2 d-inline-block custom-radio" v-for="(item, index) in data.areas" :key="index">
                        <Field v-slot="{ field }" name="area_id" rules="required">
                          <input
                              name="area_id"
                              type="radio"
                              v-bind="field"
                              :value="item.id"
                              :id="'area_id' + index"
                          >
                        </Field>
                        <label :for="'area_id' + index" class="font-15 lh-20">{{ item.label }}</label>
                      </div>
                      <br>
                      <ErrorMessage class="error" name="area_id" />
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr>
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
                            placeholder="例）
・作業内容
・求めるスキル・経験
・希望条件（職種・希望単価・稼働開始時期）
・お問い合わせの背景"
                            class="form-control"
                        />
                        <ErrorMessage class="error" name="contact_content" />
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
                        <label @click="openTab(data.openTabPolicy)" for="policy" class="text-decoration-underline font-15 lh-20"
                        >プライバシーポリシーに同意する</label
                        >
                        <br/>
                        <ErrorMessage class="error" name="policy" />
                      </div>
                      <button
                          :disabled="!model.agree"
                          v-bind:class="{ active: model.agree }"
                          class="btn-form-submit event-link"
                          type="submit"
                      >
                        同意して送信
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
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
import Loader from "../common/loader.vue";
import {
  Form as VeeForm,
  Field,
  ErrorMessage,
  defineRule,
  configure,
} from "vee-validate";
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import $ from "jquery";
import axios from "axios";
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
          company_name: {
            required: "会社名を入力してください",
            max: "会社名は255文字以内で入力してください",
          },
          department_name: {
            max: "部署名は255文字以内で入力してください",
          },
          contact_hira_last_name: {
            required: "名を入力してください",
            max: "50文字を超えました",
            hiragana: "間違ったフォーマット",
          },
          contact_hira_first_name: {
            required: "姓を入力してください",
            max: "50文字を超えました",
            hiragana: "間違ったフォーマット",
          },
          contact_kata_first_name: {
            max: "50文字以内で入力してください",
            katakana: "全角カタカナで入力してください",
          },
          contact_kata_last_name: {
            required: "メイを入力してください",
            max: "50文字以内で入力してください",
            katakana: "全角カタカナで入力してください",
          },
          contact_phone_number: {
            required: "ご連絡先電話番号を入力してください",
            max: "ご連絡先電話番号は255文字以内で入力してください",
            telephone: "正しい電話番号をハイフンありでご記入ください",
          },
          contact_email: {
            required: "メールアドレスを入力してください",
            email: "メールアドレスを正確に入力してください",
            max: "メールアドレスは255文字以内で入力してください",
          },
          contact_content	: {
            required: "お問い合わせ内容を入力してください",
            max: "20,000文字以内で入力してください",
          },
          area_id	: {
            required: "ご希望のエリアを入力してください",
          },
          contact_email_confirm: {
            required: "確認用メールアドレスを入力してください",
            email_confirm: "メールアドレスが一致しません",
            email: "正しいメールアドレスを入力してください",
            max: "メールアドレスは255文字以内で入力してください",
          },
          policy: {
            required: "プライバシーポリシーに同意してください",
          },
        }
      },
    };
    configure({
      generateMessage: localize(messError),
    });

    let that = this;
    defineRule("unique_contact_email", (value) => {
      return axios
          .post(that.data.urlCheckEmail, {
            _token: Laravel.csrfToken,
            value: value
          })
          .then(function (response) {
            return response.data.valid;
          })
          .catch((error) => {});
    });
    defineRule("email_confirm", (value) => {
      if (value !== this.model.contact_email) return false;
      return true;
    });
  },
  data() {
    return {
      showOption : false,
      flagShowLoader: false,
      model: {
        company_name: '',
        department_name: '',
        contact_hira_first_name: '',
        contact_hira_last_name: '',
        contact_kata_first_name: '',
        contact_kata_last_name: '',
        contact_phone_number: '',
        contact_email: '',
        contact_email_confirm: '',
        area_id: '',
        contact_content: '',
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
    openTab(href){
      window.open(href);
    },
    onInvalidSubmit({ values, errors, results }) {
      let firstInputError = Object.entries(errors)[0][0];
      this.$el.querySelector("input[name=" + firstInputError + "]").focus();
    },
    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formData.submit();
    },
  },
};
</script>
