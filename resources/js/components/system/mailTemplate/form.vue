<template>
  <div class="container">
    <div class="fade-in">
      <CRow>
        <CCol :sm="12">
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
              enctype="multipart/form-data"
            >
              <CCard v-show="step == 1">
                <Field type="hidden" :value="csrfToken" name="_token" />
                <Field
                  type="hidden"
                  value="PUT"
                  name="_method"
                  v-if="data.isEdit"
                />
                <CCardHeader>
                  <CFormLabel>{{ data.name_layout }}</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >メールテンプレート名</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="mail_name"
                        v-model="model.mail_name"
                        rules="required|max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="mail_name" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input">差出人名</CFormLabel>
                    <div class="col-sm-6">
                      <Field
                        name="mail_from_user_name"
                        v-model="model.mail_from_user_name"
                        rules="max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="mail_from_user_name" />
                      <div class="small">
                        ※空白の場合は、差出人名を指定しません。（差出人メールアドレスが表示されます。）
                      </div>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >返信先メールアドレス
                    </CFormLabel>
                    <div class="col-sm-6">
                      <Field
                        name="mail_reply_to_email"
                        v-model="model.mail_reply_to_email"
                        rules="max:255|email"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="mail_reply_to_email" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >件名
                    </CFormLabel>
                    <div class="col-sm-6">
                      <div class="group-mail mb-2">
                        <div>
                          <Field
                            as="select"
                            name="mail_master_subject_id"
                            placeholder="年"
                            v-model="model.mail_master_subject_id"
                            class="form-select"
                          >
                            <option value="" selected disabled>
                              変数を選択
                            </option>
                            <option
                              v-for="master of data.mail_masters"
                              :key="master.id"
                              :value="master.id"
                            >
                              {{ master.label }}
                            </option>
                          </Field>
                          <ErrorMessage
                            class="error"
                            name="mail_master_subject_id"
                          />
                        </div>
                        <div>
                          <CButton
                            type="button"
                            class="btn-primary btn-w-100"
                            :disabled="!model.mail_master_subject_id"
                            @click="fillMasterContent('subject')"
                          >
                            読み込む
                          </CButton>
                        </div>
                      </div>
                      <Field
                        name="mail_subject"
                        v-model="model.mail_subject"
                        rules="required|max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="mail_subject" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >本文
                    </CFormLabel>
                    <div class="col-sm-6">
                      <div class="group-mail mb-2">
                        <div>
                          <Field
                            as="select"
                            name="mail_body_select"
                            placeholder="年"
                            v-model="model.mail_master_body_id"
                            class="form-select"
                          >
                            <option value="" selected disabled>
                              変数を選択
                            </option>
                            <option
                              v-for="master of data.mail_masters"
                              :key="master.id"
                              :value="master.id"
                            >
                              {{ master.label }}
                            </option>
                          </Field>
                          <ErrorMessage
                            class="error"
                            name="mail_master_subject_id"
                          />
                        </div>
                        <div>
                          <CButton
                            type="button"
                            class="btn-primary btn-w-100"
                            :disabled="!model.mail_master_body_id"
                            @click="fillMasterContent('body')"
                          >
                            読み込む
                          </CButton>
                        </div>
                      </div>
                      <Field
                        as="textarea"
                        name="mail_body"
                        v-model="model.mail_body"
                        rules="required|max:1000"
                        rows="5"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="mail_body" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >添付ファイル</CFormLabel
                    >
                    <div class="col-sm-6">
                      <UploadFile
                        name="mail_send_file_path"
                        :initFile="data.template.files"
                        @onSelectFile="onSelectFile"
                        @onRemoveFile="onRemoveFile"
                      ></UploadFile>
                      <Field
                        type="hidden"
                        name="file_size"
                        id="file_size"
                        v-model="model.file_size"
                        rules="max_value:524288000"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="file_size" />
                    </div>
                  </CRow>
                </CCardBody>
                <CCardFooter>
                  <div class="col-md-12 text-center btn-box">
                    <CButton type="submit" class="btn-primary btn-w-100">
                      確認する
                    </CButton>
                    <a :href="data.urlBack" class="btn btn-default btn-w-100">
                      キャンセル
                    </a>
                  </div>
                </CCardFooter>
              </CCard>
              <CCard v-show="step == 2">
                <CCardHeader>
                  <CFormLabel>新規メールテンプレート確認</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>メールテンプレート名</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ model.mail_name }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>差出人名</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ model.mail_from_user_name }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>返信先メールアドレス</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ model.mail_reply_to_email }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>件名</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ model.mail_subject }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>本文</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel
                        v-html="convertNl2br(model.mail_body)"
                      ></CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>添付ファイル</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel id="lbl-file-name"></CFormLabel>
                    </div>
                  </CRow>
                </CCardBody>
                <CCardFooter>
                  <div class="col-md-12 text-center btn-box">
                    <CButton
                      type="submit"
                      @click="submitConfirm"
                      for="formData"
                      class="btn-primary btn-w-100"
                    >
                      作成する
                    </CButton>
                    <a @click="backStep" class="btn btn-default btn-w-100">
                      キャンセル
                    </a>
                  </div>
                </CCardFooter>
              </CCard>
            </form>
          </VeeForm>
        </CCol>
      </CRow>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<script>
import Loader from "../../common/loader";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import {
  Form as VeeForm,
  Field,
  ErrorMessage,
  defineRule,
  configure,
} from "vee-validate";
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import Toggle from "@vueform/toggle";
import "@vueform/toggle/themes/default.css";
import UploadFile from "../../common/UploadFile.vue";
import $ from "jquery";

export default {
  setup() {
    Object.keys(rules).forEach((rule) => {
      if (rule != "default") {
        defineRule(rule, rules[rule]);
      }
    });
  },
  components: {
    Loader,
    VeeForm,
    Field,
    ErrorMessage,
    Datepicker,
    Toggle,
    UploadFile,
  },
  computed: {},
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: this.data.isEdit ? this.data.template : {},
      step: 1,
    };
  },
  created() {
    if (!this.data.template || !this.data.template.files) {
      if (!this.data.template) {
        this.data.template = {};
      }
      this.data.template.files = []
    }
    let messError = {
      en: {
        fields: {
          mail_name: {
            required: "メールテンプレート名を入力してください。",
            max: "メールテンプレート名は255文字を超えてはなりません",
          },
          mail_from_user_name: {
            required: "差出人名を入力してください。",
            max: "差出人名は255文字を超えてはなりません",
          },
          mail_reply_to_email: {
            required: "返信先メールアドレスを入力してください。",
            max: "返信先メールアドレスは255文字を超えてはなりません",
            email: "メールアドレスが無効です",
          },
          mail_subject: {
            required: "件名を入力してください。",
            max: "読み込むは255文字を超えてはなりません",
          },
          mail_body: {
            required: "本文を入力してください。",
            max: "本文は1000文字を超えてはなりません",
          },
          file_size: {
            max_value: "500MB以下のファイルをアップロードしてください。"
          }
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });
  },
  methods: {
    onSelectFile(files) {
      this.model.file_size = files[0] ? files[0].size : 0;
    },
    onRemoveFile(files) {
      this.model.file_size = 0;
    },
    convertNl2br(data) {
      if (data) {
        data = data.replace(/(?:\r\n|\r|\n)/g, "<br />");
      }
      return data;
    },
    backStep() {
      this.step = 1;
    },
    fillMasterContent(type) {
      const masterTypes = {
        subject: { id: "mail_master_subject_id", target: "mail_subject" },
        body: { id: "mail_master_body_id", target: "mail_body" },
      };

      if (!type || !Object.keys(masterTypes).includes(type)) {
        return false;
      }

      const fieldName = masterTypes[type];
      const master = this.data.mail_masters.find(
        (h) => h.id === this.model[fieldName.id]
      );

      if (fieldName && master) {
        if (!this.model[fieldName.target]) {
          this.model[fieldName.target] = "";
        }
        this.model[fieldName.target] += " " + master.key;
      }

      return true;
    },
    onInvalidSubmit({ values, errors, results }) {
      let firstInputError = Object.entries(errors)[0][0];
      this.$el.querySelector("input[name='" + firstInputError + "']").focus();
      $("html, body").animate(
        {
          scrollTop:
            $("input[name='" + firstInputError + "']").offset().top - 150,
        },
        500
      );
    },
    submitConfirm() {
      this.onSubmit();
    },
    onSubmit() {
      if (this.step == 1) {
        $("#lbl-file-name").text('');
        if ($(".file-name").html()) {
          $("#lbl-file-name").text($(".file-name").html());
        }
        this.step = 2;
      } else {
        this.flagShowLoader = true;
        this.$refs.formData.submit();
      }
    },
  },
};
</script>
