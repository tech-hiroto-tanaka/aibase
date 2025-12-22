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
              :action="data.urlSubmit"
              ref="formData"
              enctype="multipart/form-data"
            >
              <search
                v-show="step == 1"
                :conditions="conditions"
                :data="data"
              ></search>
              <CCard v-show="step == 1">
                <Field type="hidden" :value="csrfToken" name="_token" />
                <Field
                  type="hidden"
                  value="PUT"
                  name="_method"
                  v-if="data.isEdit"
                />
                <CCardHeader>
                  <CFormLabel>{{ data.title }}</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >メールテンプレート</CFormLabel
                    >
                    <div class="col-sm-6">
                      <div class="group-mail mb-2">
                        <div>
                          <Field
                            as="select"
                            name="mail_template_id"
                            placeholder="メールテンプレートを選択"
                            v-model="templateId"
                            class="form-select"
                          >
                            <option value="" selected disabled>
                              メールテンプレートを選択
                            </option>
                            <option
                              v-for="template of data.templates"
                              :key="template.id"
                              :value="template.id"
                            >
                              {{ template.mail_name }}
                            </option>
                          </Field>
                          <div class="small">
                            ※メールテンプレートは
                            <a :href="data.urlCreateTemplate">こちらから</a>
                            作成できます。
                          </div>
                        </div>
                        <div>
                          <CButton
                            type="button"
                            class="btn-primary btn-w-100"
                            :disabled="!templateId"
                            @click="fillContentTemplate"
                          >
                            読み込む
                          </CButton>
                        </div>
                      </div>
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
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >返信先メールアドレス
                    </CFormLabel>
                    <div class="col-sm-6">
                      <Field
                        name="mail_reply_to_email"
                        v-model="model.mail_reply_to_email"
                        rules="required|max:255|email"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="mail_reply_to_email" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >配信開始日時
                    </CFormLabel>
                    <div class="col-sm-6">
                      <Field
                        as="div"
                        name="mail_send_datetime"
                        v-model="model.mail_send_datetime"
                        rules="required"
                      >
                        <datepicker
                          autoApply
                          keepActionRow
                          :closeOnAutoApply="false"
                          v-model="model.mail_send_datetime"
                          :monthChangeOnScroll="false"
                          locale="ja-jp"
                          name="mail_send_datetime"
                          selectText="選択"
                          cancelText="閉じる"
                          class="width-200"
                          format="yyyy/MM/dd HH:mm"
                        />
                      </Field>
                      <div class="small">
                        ※配信開始日時が過去の日時になっている場合には、即時配信開始となります。
                      </div>
                      <ErrorMessage
                        class="error"
                        name="mail_send_datetime"
                      ></ErrorMessage>
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
                      >ファイルを添付</CFormLabel
                    >
                    <div class="col-sm-6">
                      <UploadFile
                        name="mail_send_file_path"
                        :initFile="model.files"
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
                      確認
                    </CButton>
                    <a :href="data.urlBack" class="btn btn-default btn-w-100">
                      キャンセル
                    </a>
                  </div>
                </CCardFooter>
              </CCard>
              <CCard class="mb-2" v-show="step == 2">
                <CCardHeader>
                  <CFormLabel>配信条件</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>ユーザー名</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ conditions.name }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>フリガナ</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ conditions.name_furigana }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>性別 </CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ arrGender.join(",") }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>生年月日</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{
                        formatDate(conditions.birthday)
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>メールアドレス</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ conditions.email }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>ご連絡先電話番号</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ conditions.phone_number }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>お住いのエリア</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ arrArea.join(",") }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>希望就業時期</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ arrDesire.join(",") }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>経験スキル</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{
                        conditions.experience_skills_detail
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>最寄駅</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{
                        conditions.nearest_station_name
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>その他ご要望</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{
                        conditions.other_requests
                      }}</CFormLabel>
                    </div>
                  </CRow>
                </CCardBody>
              </CCard>
              <CCard v-show="step == 2">
                <CCardHeader>
                  <CFormLabel>新規メール確認</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>メールテンプレート</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ templateId && data.templates.find(x => x.id == templateId) ? data.templates.find(x => x.id == templateId).mail_name : '' }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <div class="col-sm-3">
                      <CFormLabel>差出人名</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{ model.mail_from_user_name != '' ? model.mail_from_user_name : data.MAIL_FROM_ADDRESS }}</CFormLabel>
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
                      <CFormLabel>配信開始日時</CFormLabel>
                    </div>
                    <div class="col-sm-9">
                      <CFormLabel>{{
                        formatDate1(model.mail_send_datetime)
                      }}</CFormLabel>
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
                      <CFormLabel>ファイルを添付</CFormLabel>
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
                      登録
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
import Search from "./search.vue";
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
    Search,
  },
  computed: {},
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: this.data.isEdit ? this.data.schedule : {},
      conditions: this.data.isEdit ? this.data.schedule.mail_condition : {},
      templateId: this.data.isEdit ? this.data.schedule.mail_template_id : "",
      step: 1,
      arrGender: [],
      arrArea: [],
      arrDesire: [],
    };
  },
  created() {
    if (!this.data.model || !this.data.model.files) {
      if (!this.data.model) {
        this.data.model = {};
      }
      this.data.model.files = [];
    }
    if (this.data.request && this.data.request.mail_condition) {
      this.conditions = this.data.request.mail_condition;
    }
    let messError = {
      en: {
        fields: {
          mail_send_datetime: {
            required: "配信開始日時を入力してください。",
          },
          mail_name: {
            required: "テンプレート名を入力してください。",
            max: "テンプレート名は255文字を超えてはなりません",
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
    formatDate(day) {
      if (!day) {
        return "";
      }
      var d = new Date(day);
      return (
        d.getFullYear() +
        "/" +
        (d.getMonth() + 1 < 10 ? "0" + (d.getMonth() + 1) : d.getMonth() + 1) +
        "/" +
        (d.getDate() < 10 ? "0" + d.getDate() : d.getDate())
      );
    },
    formatDate1(day) {
      var d = new Date(day);
      return (
        d.getFullYear() +
        "/" +
        (d.getMonth() + 1 < 10 ? "0" + (d.getMonth() + 1) : d.getMonth() + 1) +
        "/" +
        (d.getDate() < 10 ? "0" + d.getDate() : d.getDate()) +
        " " +
        (d.getHours() < 10 ? "0" + d.getHours() : d.getHours()) +
        ":" +
        (d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes())
      );
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
    fillContentTemplate() {
      this.model = this.data.templates.find((x) => x.id == this.templateId);
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
        this.arrGender = [];
        if ($(".mail_condition-male").is(":checked")) {
          this.arrGender.push("男性");
        }
        if ($(".mail_condition-female").is(":checked")) {
          this.arrGender.push("女性");
        }
        $("#lbl-file-name").text("");
        if ($(".file-name").html()) {
          $("#lbl-file-name").text($(".file-name").html());
        }
        let that = this;
        $(".check-area:checked").each(function () {
          that.arrArea.push($(this).attr("data-txt"));
        });
        $(".check-desire:checked").each(function () {
          that.arrDesire.push($(this).attr("data-txt"));
        });
        this.step = 2;
      } else {
        this.flagShowLoader = true;
        this.$refs.formData.submit();
      }
    },
  },
};
</script>
