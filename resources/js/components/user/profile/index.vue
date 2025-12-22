<template>
  <div class="container">
    <div class="fade-in page-register p-profile mt-4">
      <div class="row justify-content-center">
        <div class="col-md-7">
          <VeeForm
            as="div"
            v-slot="{ handleSubmit }"
            @invalid-submit="onInvalidSubmit"
          >
            <form
              method="POST"
              @submit="handleSubmit($event, onSubmit)"
              :action="data.urlUpdateProfile"
              ref="formData"
              class="formRegister"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
              <Field type="hidden" value="PUT" name="_method" />
              <div class="card">
                <div class="card-body card-register">
                  <div class="row justify-content-center">
                    <div class="col-sm-12 text-center mb-5">
                      <h4 class="title">マイページ</h4>
                    </div>
                  </div>
                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-12 col-sm-3 r-mb-1 d-lbl font-15 lh-20">
                      お名前
                      <span class="required">必須</span>
                    </div>
                    <div class="col-12 col-sm-8">
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
                            <ErrorMessage
                              class="error"
                              name="hira_last_name"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-12 col-sm-3 r-mb-1 font-15 lh-20 d-lbl">
                      フリガナ
                      <span class="required">必須</span>
                    </div>
                    <div class="col-12 col-sm-8">
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
                            <ErrorMessage
                              class="error"
                              name="kata_first_name"
                            />
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

                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-4 col-sm-3 r-mb-1 font-15 d-lbl lh-20">
                      性別
                      <span class="required">必須</span>
                    </div>
                    <div class="col-8 col-sm-8 d-flex d-lbl">
                      <div
                        class="form-group me-3"
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
                          />
                          <label :for="'gender' + index" class="ms-2 font-15">{{
                            item.label
                          }}</label>
                        </Field>
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-12 col-sm-3 r-mb-1 font-15 lh-20 d-lbl">
                      生年月日
                      <span class="required">必須</span>
                    </div>
                    <div class="col-12 col-sm-8">
                      <div class="d-flex">
                        <div class="form-group w-30">
                          <Field
                            type="hidden"
                            name="birthday"
                            v-model="model.birthday"
                            rules="required|format_day"
                          />
                          <Field
                            name="year"
                            v-model="model.year"
                            @change="generateBirthday"
                            placeholder="2020"
                            class="form-control d-inline"
                          />
                          <label class="ms-2 font-16 lh-24">年</label>
                        </div>
                        <div class="form-group w-25 r-w-30">
                          <Field
                            name="month"
                            v-model="model.month"
                            placeholder="04"
                            @change="generateBirthday"
                            class="form-control d-inline"
                          />
                          <label class="ms-2 font-16 lh-24">月</label>
                        </div>
                        <div class="form-group w-25 r-w-30">
                          <Field
                            name="day"
                            v-model="model.day"
                            @change="generateBirthday"
                            placeholder="01"
                            class="form-control d-inline"
                          />
                          <label class="ms-2 font-16 lh-24">日</label>
                        </div>
                      </div>
                      <ErrorMessage class="error" name="birthday" />
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-12 col-sm-3 r-mb-1 font-15 lh-20 d-lbl">
                      メールアドレス
                      <span class="required">必須</span>
                    </div>
                    <div class="col-12 col-sm-8">
                      <div class="form-group">
                        <Field
                          name="email"
                          v-model="model.email"
                          rules="required|email|unique_custom"
                          placeholder="taro@example.jp"
                          class="form-control"
                        />
                        <ErrorMessage class="error" name="email" />
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-12 col-sm-3 r-mb-1 font-15 lh-20 d-lbl">
                      パスワード
                      <span class="no-required">任意</span>
                    </div>
                    <div class="col-12 col-sm-8">
                      <div class="form-group">
                        <Field
                          name="password"
                          type="password"
                          autocomplete="new-password"
                          v-model="model.password"
                          rules="max:32|min:8|password_rule"
                          class="form-control"
                          ref="password"
                        />
                        <ErrorMessage class="error" name="password" />
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-12 col-sm-3 r-mb-1 font-15 lh-20 d-lbl">
                      ご連絡先電話番号
                      <span class="required">必須</span>
                    </div>
                    <div class="col-12 col-sm-8">
                      <div class="form-group">
                        <Field
                          name="phone_number"
                          v-model="model.phone_number"
                          rules="required|telephone"
                          placeholder="000-0000-0000"
                          class="form-control"
                        />
                        <ErrorMessage class="error" name="phone_number" />
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-center mb-3">
                    <hr />
                    <div class="col-12 col-sm-3 r-mb-1 font-15 lh-20 d-lbl">
                      お住いのエリア
                      <span class="required">必須</span>
                    </div>
                    <div class="col-12 col-sm-8">
                      <div class="form-group">
                        <span
                          v-for="area in data.areas"
                          :key="area.id"
                          class="area-item"
                        >
                          <Field
                            type="radio"
                            name="area_id"
                            :value="area.id"
                            :id="'area_' + area.id"
                            rules="required"
                            v-model="model.area_id"
                          />
                          <label
                            class="ms-2 font-15"
                            :for="'area_' + area.id"
                            >{{ area.area_name }}</label
                          >
                        </span>
                      </div>
                      <ErrorMessage class="error" name="area_id" />
                    </div>
                  </div>

                  <div
                    class="row justify-content-center align-items-center mb-4"
                  >
                    <div class="bg-list-option">
                      <div class="col-12">
                        <div
                          class="option-skills"
                          @click="showOption = !showOption"
                        >
                          <span
                            class="icon-plus"
                            :class="{ active: showOption }"
                          ></span>
                          <span class="text">
                            (任意）スキル・ご希望にお答えいただければ、より最適な営業担当からご連絡させていただきます。</span
                          >
                        </div>
                      </div>

                      <div class="list-option" :class="{ active: showOption }">
                        <div
                          class="
                            row
                            justify-content-center
                            align-items-center
                            mb-4
                          "
                        >
                          <hr />
                          <div
                            class="col-12 col-sm-3 r-mb-1 font-15 lh-27-5 d-lbl"
                          >
                            希望就業時期
                            <span class="no-required">任意</span>
                          </div>
                          <div
                            class="
                              col-12 col-sm-8 col-c-sm-8
                              desired-work-radio
                            "
                          >
                            <div
                              class="form-group"
                              v-for="(item, index) in data.desiredWorkType"
                              :key="item.id"
                            >
                              <Field
                                type="radio"
                                name="desired_work_type"
                                :value="item.id"
                                v-model="model.desired_work_type"
                                :id="'desired_work_type_' + index"
                                ref="desired_work_type"
                              />
                              <label
                                :for="'desired_work_type_' + index"
                                class="ms-2 font-15"
                                >{{ item.label }}</label
                              >
                            </div>
                          </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                          <hr />
                          <div
                            class="col-12 col-sm-3 r-mb-1 font-15 lh-27-5 d-lbl"
                          >
                            経験スキル
                            <span class="no-required">任意</span>
                          </div>
                          <div class="col-12 col-sm-8 col-c-sm-8">
                            <div class="form-group">
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
                          </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                          <hr />
                          <div
                            class="col-12 col-sm-3 r-mb-1 font-15 lh-27-5 d-lbl"
                          >
                            最寄駅
                            <span class="no-required">任意</span>
                          </div>
                          <div class="col-12 col-sm-8 col-c-sm-8">
                            <div class="d-flex">
                              <div class="form-group w-70 r-w-100">
                                <Field
                                  name="nearest_station_name"
                                  v-model="model.nearest_station_name"
                                  rules="max:255"
                                  placeholder="JR山手線　東京"
                                  class="form-control w-60 r-w-90 d-inline"
                                />
                                <label class="ms-2 font-16 lh-24">駅</label>
                              </div>
                            </div>
                            <ErrorMessage
                              class="error"
                              name="nearest_station_name"
                            />
                          </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                          <hr />
                          <div
                            class="col-12 col-sm-3 r-mb-1 font-15 lh-27-5 d-lbl"
                          >
                            その他ご要望
                            <span class="no-required">任意</span>
                          </div>
                          <div class="col-12 col-sm-8 col-c-sm-8">
                            <div class="form-group">
                              <Field
                                as="textarea"
                                name="other_requests"
                                v-model="model.other_requests"
                                rules="max:20000"
                                rows="6"
                                placeholder="ご希望のお仕事内容をご記入ください。&#10;例）Web系の開発工程を希望。作業場所は〇〇&#10;駅から一時間圏内。希望月収は手取りで〇〇万&#10;円程度。"
                                class="form-control"
                              />
                              <ErrorMessage
                                class="error"
                                name="other_requests"
                              />
                            </div>
                            <div class="form-group font-11 lh-22 mt-3">
                              <div>
                                弊社tのお打ち合わせをご希望の場合は、可能な日時もしくは曜日や時間帯などご記入ください。
                              </div>
                              <div>
                                （営業時間 平日9:00-18:00 土日祝除く）
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-12 text-center">
                      <button class="btn-form-submit event-link" type="submit">
                        保存する
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="10.16"
                          height="5.535"
                          viewBox="0 0 10.16 5.535"
                        >
                          <g
                            id="Group_834"
                            data-name="Group 834"
                            transform="translate(-339.5 -478.327)"
                          >
                            <line
                              id="Line_33"
                              data-name="Line 33"
                              x2="9"
                              transform="translate(339.5 481.094)"
                              fill="none"
                              stroke="#000"
                              stroke-width="1"
                            ></line>
                            <path
                              id="Path_2477"
                              data-name="Path 2477"
                              d="M3161.021,440.394l2.414-2.414,2.414,2.414"
                              transform="translate(786.933 -2682.341) rotate(90)"
                              fill="none"
                              stroke="#000"
                              stroke-width="1"
                            ></path>
                          </g>
                        </svg>
                      </button>
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
          birthday: {
            required: "生年月日を入力してください",
            format_day: "正しい日付を入力してください",
          },
          email: {
            required: "メールアドレスを入力してください",
            email: "正しいメールアドレスを入力してください",
            unique_custom: "このメールアドレスは既に登録されています",
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
            format_day: "正しい日付を入力してください",
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
  data() {
    return {
      showOption: false,
      flagShowLoader: false,
      model: {
        hira_first_name: this.data.user.hira_first_name,
        hira_last_name: this.data.user.hira_last_name,
        kata_first_name: this.data.user.kata_first_name,
        kata_last_name: this.data.user.kata_last_name,
        gender: this.data.user.gender,
        year: this.data.user.birthday.split("-")[0],
        birthday: this.data.user.birthday_date_format,
        month: this.data.user.birthday.split("-")[1],
        day: this.data.user.birthday.split("-")[2],
        email: this.data.user.email,
        phone_number: this.data.user.phone_number,
        area_id: this.data.user.area_id,
        experience_skills_detail: this.data.user.experience_skills_detail,
        nearest_station_name: this.data.user.nearest_station_name,
        other_requests: this.data.user.other_requests,
        policy: this.data.user.policy,
        desired_work_type: this.data.user.desired_work_type,
        experience_skills_from_date:
          this.data.user.experience_skills_from_date_format,
        experience_skills_year: this.data.user.experience_skills_from_date
          ? this.data.user.experience_skills_from_date.split("-")[0]
          : "",
        experience_skills_month: this.data.user.experience_skills_from_date
          ? this.data.user.experience_skills_from_date.split("-")[1]
          : "",
        experience_skills_day: this.data.user.experience_skills_from_date
          ? this.data.user.experience_skills_from_date.split("-")[2]
          : "",
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
      if (
        firstInputError == "birthday" ||
        firstInputError == "experience_skills_from_date"
      ) {
        firstInputError = $("[name='" + firstInputError + "']")
          .closest("div")
          .find(".form-control")
          .attr("name");
      }
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
    generateBirthday() {
      this.model.birthday =
        this.model.year + "/" + this.model.month + "/" + this.model.day;
      if (!this.model.year && !this.model.month && !this.model.day) {
        this.model.birthday = "";
      }
    },
    generateExperienceSkillsDate() {
      this.model.experience_skills_from_date =
        this.model.experience_skills_year +
        "/" +
        this.model.experience_skills_month +
        "/" +
        this.model.experience_skills_day;
      if (
        !this.model.experience_skills_year &&
        !this.model.experience_skills_month &&
        !this.model.experience_skills_day
      ) {
        this.model.experience_skills_from_date = "";
      }
    },
  },
  watch: {},
};
</script>
