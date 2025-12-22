<template>
  <div class="container">
    <div class="fade-in system-create-user">
      <CRow>
        <CCol :sm="12">
          <CCard>
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
              >
                <Field type="hidden" :value="csrfToken" name="_token" />
                <CCardHeader>
                  <CFormLabel>{{ data.title }}</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >お名前</CFormLabel
                    >
                    <div class="col-sm-3">
                      <Field
                        name="hira_first_name"
                        v-model="model.hira_first_name"
                        rules="required|max:50"
                        class="form-control"
                        placeholder="姓"
                      />
                      <ErrorMessage class="error" name="hira_first_name" />
                    </div>
                    <div class="col-sm-3">
                      <Field
                        name="hira_last_name"
                        v-model="model.hira_last_name"
                        rules="required|max:50"
                        class="form-control"
                        placeholder="名"
                      />
                      <ErrorMessage class="error" name="hira_last_name" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >フリガナ</CFormLabel
                    >
                    <div class="col-sm-3">
                      <Field
                        name="kata_first_name"
                        v-model="model.kata_first_name"
                        rules="required|katakana|max:50"
                        class="form-control"
                        placeholder="セイ"
                      />
                      <ErrorMessage class="error" name="kata_first_name" />
                    </div>
                    <div class="col-sm-3">
                      <Field
                        name="kata_last_name"
                        v-model="model.kata_last_name"
                        rules="required|katakana|max:50"
                        class="form-control"
                        placeholder="メイ"
                      />
                      <ErrorMessage class="error" name="kata_last_name" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >性別</CFormLabel
                    >
                    <div class="col-sm-6">
                      <div
                        class="form-check form-check-inline"
                        :key="item.id"
                        v-for="(item, index) in data.gender"
                      >
                        <Field as="div" name="gender">
                          <input
                            type="radio"
                            name="gender"
                            v-model="model.gender"
                            :value="item.id"
                            :id="'gender' + index"
                            class="form-check-input"
                          />
                          <label :for="'gender' + index">{{
                            item.label
                          }}</label>
                        </Field>
                      </div>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >生年月日</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="div"
                        name="birthday"
                        v-model="model.birthday"
                        rules="required"
                      >
                        <datepicker
                          autoApply
                          keepActionRow
                          :closeOnAutoApply="false"
                          v-model="model.birthday"
                          :monthChangeOnScroll="false"
                          locale="ja"
                          name="birthday"
                          selectText="選択"
                          cancelText="閉じる"
                          class="width-200"
                          format="yyyy/MM/dd"
                          rules="required"
                          :enableTimePicker="false"
                        />
                      </Field>
                      <ErrorMessage class="error" name="birthday" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >メールアドレス</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="email"
                        type="text"
                        autocomplete="new-password"
                        v-model="model.email"
                        placeholder="taro@example.jp"
                        rules="required|unique_custom|email"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="email" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >パスワード</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        v-model="model.password"
                        placeholder=""
                        rules="required|password_rule|max:32|min:8"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="password" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >ご連絡先電話番号</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="phone_number"
                        type="text"
                        v-model="model.phone_number"
                        placeholder="000-0000-0000"
                        rules="required|telephone"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="phone_number" />
                    </div>
                  </CRow>
                  <!-- Areas -->
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >お住いのエリア</CFormLabel
                    >
                    <div class="col-sm-6">
                      <span
                        v-for="area in data.areas"
                        :key="area.id"
                        class="area-item"
                      >
                        <Field
                          type="radio"
                          name="area_id"
                          :value="area.id"
                          v-model="model.area_id"
                          :id="'area_' + area.id"
                          rules="required"
                        />
                        <label class="ms-2 font-15" :for="'area_' + area.id">{{
                          area.area_name
                        }}</label>
                      </span>
                      <ErrorMessage class="error" name="area_id" />
                    </div>
                  </CRow>

                  <div class="others bg-gray">
                    <p class="text-center">
                      （任意）スキル・ご希望にお答えいただければ、より最適な営業担当からご連絡させていただきます。
                    </p>
                    <CRow class="mb-2">
                      <CFormLabel class="col-sm-3 lbl-input"
                        >希望就業時期</CFormLabel
                      >
                      <div class="col-sm-8">
                        <div class="col-12 col-sm-9 desired-work-radio">
                          <div
                            class="form-group d-inline-block mr-4"
                            v-for="(item, index) in data.desiredWorkType"
                            :key="item.id"
                          >
                            <Field
                              type="radio"
                              name="desired_work_type"
                              :value="item.id"
                              :id="'desired_work_type_' + index"
                              ref="desired_work_type"
                              class="form-check-input"
                            />
                            <label
                              :for="'desired_work_type_' + index"
                              class="ms-2"
                              >{{ item.label }}</label
                            >
                          </div>
                        </div>
                        <ErrorMessage class="error" name="desired_work_type" />
                      </div>
                    </CRow>
                    <CRow class="mb-2">
                      <CFormLabel class="col-sm-3 lbl-input"
                        >経験スキル</CFormLabel
                      >
                      <div class="col-sm-6">
                        <Field
                          as="textarea"
                          name="experience_skills_detail"
                          v-model="model.experience_skills_detail"
                          rules="max:20000"
                          rows="6"
                          placeholder="Java開発経験　5年&#10;Windowsサーバー設計・構築経験　3年"
                          class="form-control"
                        />
                        <ErrorMessage
                          class="error"
                          name="experience_skills_detail"
                        />
                      </div>
                    </CRow>

                    <CRow class="mb-2">
                      <CFormLabel class="col-sm-3 lbl-input">最寄駅</CFormLabel>
                      <div class="col-sm-6">
                        <div class="d-flex">
                          <div class="form-group w-70">
                            <Field
                              name="nearest_station_name"
                              v-model="model.nearest_station_name"
                              rules="max:255"
                              placeholder="JR山手線　東京"
                              class="form-control w-60 d-inline"
                            />
                            <label class="ms-2 d-inline-block">駅</label>
                          </div>
                        </div>
                        <ErrorMessage
                          class="error"
                          name="nearest_station_name"
                        />
                      </div>
                    </CRow>
                    <CRow class="mb-2">
                      <CFormLabel class="col-sm-3 lbl-input"
                        >その他ご要望</CFormLabel
                      >
                      <div class="col-sm-6">
                        <Field
                          as="textarea"
                          name="other_requests"
                          v-model="model.other_requests"
                          rules="max:20000"
                          rows="6"
                          placeholder="ご希望のお仕事内容をご記入ください。
例）Web系の開発工程を希望。作業場所は〇〇駅から一時間圏内。希望月収は手取りで〇〇万円程度。"
                          class="form-control"
                        />
                        <ErrorMessage class="error" name="other_requests" />
                        <div class="form-group font-11 mt-3">
                          <div>
                            弊社tのお打ち合わせをご希望の場合は、可能な日時もしくは曜日や時間帯などご記入ください。
                          </div>
                          <div>
                            （営業時間 平日9:00-18:00 土日祝除く）
                          </div>
                        </div>
                      </div>
                    </CRow>
                  </div>
                </CCardBody>
                <CCardFooter>
                  <div class="col-md-12 text-center btn-box">
                    <CButton type="submit" class="btn-primary btn-w-100">
                      登録
                    </CButton>
                    <a :href="data.urlBack" class="btn btn-default btn-w-100">
                      キャンセル
                    </a>
                  </div>
                </CCardFooter>
              </form>
            </VeeForm>
          </CCard>
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
  components: {
    Loader,
    VeeForm,
    Field,
    ErrorMessage,
    Datepicker,
  },
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: {
        gender: 1,
      },
    };
  },
  created() {
    let messError = {
      en: {
        fields: {
          hira_first_name: {
            required: "姓を入力してください。",
            max: "50文字を超えました。",
          },
          hira_last_name: {
            required: "名を入力してください",
            max: "50文字以内で入力してください",
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
          email: {
            required: "メールアドレスを入力してください",
            email: "メールアドレスを正確に入力してください",
            unique_custom: "このメールアドレスは既に登録されています",
          },
          birthday: {
            required: "生年月日を入力してください",
          },
          password: {
            password_rule:
              "パスワードは半角英数字で、大文字、小文字、数字で入力してください",
            required: "パスワードを入力してください",
            max: "パスワードは32文字以内で入力してください",
            min: "パスワードは8文字以上で入力してください",
          },
          phone_number: {
            required: "ご連絡先電話番号を入力してください",
            telephone: "正しい電話番号をハイフンありでご記入ください",
          },
          experience_skills_detail: {
            required: "経験スキルの詳細を入力してください",
            max: "20,000文字以内で入力してください",
          },
          nearest_station_name: {
            max: "255文字以内で入力してください",
          },
          other_requests: {
            max: "20,000文字以内で入力してください",
          },
          experience_skills_from_date: {
            required: "経験スキルを入力してください",
          },
          area_id: {
            required: "エリアを選択してください",
          },
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });

    let that = this;
    defineRule("unique_custom", (value) => {
      return axios
        .post(that.data.urlCheckEmail, {
          _token: Laravel.csrfToken,
          value: value,
        })
        .then(function (response) {
          return response.data.valid;
        })
        .catch((error) => {});
    });
  },
  methods: {
    onInvalidSubmit({ values, errors, results }) {
      let firstInputError = Object.entries(errors)[0][0];
      this.$el.querySelector("[name='" + firstInputError + "']").focus();
      $("html, body").animate(
        {
          scrollTop: $("[name='" + firstInputError + "']").offset().top - 150,
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
