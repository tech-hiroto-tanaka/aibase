<template>
  <div class="container">
    <div class="fade-in">
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
                <Field
                  type="hidden"
                  v-if="data.isEdit"
                  value="PUT"
                  name="_method"
                />
                <CCardHeader>
                  <CFormLabel>{{
                    data.isEdit ? "案件編集" : "案件登録"
                  }}</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >案件コード</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="job_code"
                        v-model="model.job_code"
                        rules="required|max:255|job_code_rule|unique_custom"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="job_code" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >案件名</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="job_name"
                        v-model="model.job_name"
                        rules="required|max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="job_name" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >契約金額（税込）</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="job_cost_start"
                        v-model="model.job_cost_start"
                        rules="required|max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="job_cost_start" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"></CFormLabel>
                    <div class="col-sm-6">
                      <Field
                        name="job_cost_end"
                        v-model="model.job_cost_end"
                        rules="max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="job_cost_end" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input">作業内容</CFormLabel>
                    <div class="col-sm-6">
                      <Field
                        as="textarea"
                        rows="5"
                        name="work_content"
                        v-model="model.work_content"
                        rules="max:20000"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="work_content" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >必要スキル</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="textarea"
                        rows="5"
                        name="job_match_skill"
                        v-model="model.job_match_skill"
                        rules="max:20000"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="job_match_skill" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input">期間</CFormLabel>
                    <div class="col-sm-6">
                      <Field
                        name="job_period"
                        v-model="model.job_period"
                        rules="max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="job_period" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input">契約形態</CFormLabel>
                    <div class="col-sm-6">
                      <div class="form-check form-check-inline">
                        <Field as="div" name="type_of_job">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="type_of_job"
                            id="type_of_job0"
                            v-model="model.type_of_job"
                            value="0"
                          />
                          <label class="form-check-label" for="type_of_job0"
                            >派遣</label
                          >
                        </Field>
                      </div>
                      <div class="form-check form-check-inline">
                        <Field as="div" name="type_of_job">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="type_of_job"
                            v-model="model.type_of_job"
                            id="type_of_job1"
                            value="1"
                          />
                          <label class="form-check-label" for="type_of_job1"
                            >SES</label
                          >
                        </Field>
                      </div>
                    </div>
                  </CRow>

                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >担当者コメント</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="textarea"
                        rows="5"
                        name="office_towns"
                        v-model="model.office_towns"
                        rules="max:20000"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="office_towns" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >ジャンルを選択</CFormLabel
                    >
                    <div class="col-sm-9">
                      <CRow>
                        <div
                          class="col-sm-3"
                          v-for="item in data.genreMasters"
                          :key="item.id"
                        >
                          <Field
                            as="div"
                            name="genres"
                            v-model="model.genres"
                            class="form-check form-check-inline"
                          >
                            <input
                              class="form-check-input"
                              name="genres[]"
                              :id="'genreMasters' + item.id"
                              type="checkbox"
                              :value="item.id"
                              :checked="
                                data.isEdit &&
                                data.genreMasterList.find((x) => x == item.id)
                              "
                            />
                            <label
                              class="form-check-label"
                              :for="'genreMasters' + item.id"
                              >{{ item.genre_name }}</label
                            >
                          </Field>
                        </div>
                      </CRow>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input">エリア</CFormLabel>
                    <div class="col-sm-9">
                      <CRow>
                        <div
                          class="col-sm-12 form-area"
                          v-for="item in data.areaMasters"
                          :key="item.id"
                        >
                          <Field
                            as="div"
                            name="areas"
                            class="form-check form-check-inline"
                          >
                            <input
                              class="form-check-input input-area"
                              name="areas[]"
                              :id="'areaMasters' + item.id"
                              type="checkbox"
                              :value="item.id"
                              :checked="
                                data.isEdit &&
                                data.areaMasterList.find((x) => x == item.id)
                              "
                            />
                            <label
                              class="form-check-label"
                              :for="'areaMasters' + item.id"
                              >{{ item.area_name }}</label
                            >
                          </Field>
                          <CRow
                            class="mb-2"
                            style="margin-left: 20px"
                            v-if="
                              item.area_prefectures.length &&
                              item.area_prefectures.find(
                                (x) => x.prefecture != null
                              )
                            "
                          >
                            <template
                              v-for="pref in item.area_prefectures"
                              :key="pref.id"
                            >
                              <div class="col-sm-3" v-if="pref.prefecture">
                                <Field
                                  as="div"
                                  name="prefectures"
                                  class="form-check form-check-inline"
                                >
                                  <input
                                    class="form-check-input input-pref"
                                    name="prefectures[]"
                                    :id="
                                      'prefecturesMasters' + pref.prefecture.id
                                    "
                                    type="checkbox"
                                    :value="pref.prefecture.id"
                                    :area-id="pref.area_id"
                                    :checked="
                                      data.isEdit &&
                                      data.prefectureMasterList.find(
                                        (x) => x == pref.prefecture.id
                                      )
                                    "
                                  />
                                  <label
                                    class="form-check-label"
                                    :for="
                                      'prefecturesMasters' + pref.prefecture.id
                                    "
                                    >{{ pref.prefecture.prefecture_name }}</label
                                  >
                                </Field>
                              </div>
                            </template>
                          </CRow>
                        </div>
                      </CRow>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >スキルワード</CFormLabel
                    >
                    <div class="col-sm-9">
                      <CRow>
                        <div
                          class="col-sm-3"
                          v-for="item in data.skillWordMasters"
                          :key="item.id"
                        >
                          <Field
                            as="div"
                            name="skills"
                            class="form-check form-check-inline"
                          >
                            <input
                              class="form-check-input"
                              name="skills[]"
                              :id="'skillWordMasters' + item.id"
                              type="checkbox"
                              :value="item.id"
                              :checked="
                                data.isEdit &&
                                data.skillWordMasterList.find(
                                  (x) => x == item.id
                                )
                              "
                            />
                            <label
                              class="form-check-label"
                              :for="'skillWordMasters' + item.id"
                              >{{ item.skill_name }}</label
                            >
                          </Field>
                        </div>
                      </CRow>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input">希望単価</CFormLabel>
                    <div class="col-sm-9">
                      <CRow>
                        <div
                          class="col-sm-3"
                          v-for="item in data.desiredUnitPriceMasters"
                          :key="item.id"
                        >
                          <Field
                            as="div"
                            name="desired_costs"
                            v-model="model.desired_costs"
                            class="form-check form-check-inline"
                          >
                            <input
                              name="desired_costs[]"
                              class="form-check-input"
                              :id="'desiredUnitPriceMasters' + item.id"
                              type="checkbox"
                              :value="item.id"
                              :checked="
                                data.isEdit &&
                                data.desiredJobCostList.find(
                                  (x) => x == item.id
                                )
                              "
                            />
                            <label
                              class="form-check-label"
                              :for="'desiredUnitPriceMasters' + item.id"
                              >{{ item.desired_cost_name }}</label
                            >
                          </Field>
                        </div>
                      </CRow>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input">特徴</CFormLabel>
                    <div class="col-sm-9">
                      <CRow>
                        <div
                          class="col-sm-3"
                          v-for="item in data.featureMasters"
                          :key="item.id"
                        >
                          <Field
                            as="div"
                            name="features"
                            v-model="model.features"
                            class="form-check form-check-inline"
                          >
                            <input
                              name="features[]"
                              class="form-check-input"
                              :id="'featureMasters' + item.id"
                              type="checkbox"
                              :value="item.id"
                              :checked="
                                data.isEdit &&
                                data.jobFeatureList.find((x) => x == item.id)
                              "
                            />
                            <label
                              class="form-check-label"
                              :for="'featureMasters' + item.id"
                              >{{ item.feature_name }}</label
                            >
                          </Field>
                        </div>
                      </CRow>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >公開開始日</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="div"
                        name="job_publish_start_date"
                        v-model="model.job_publish_start_date"
                        rules="required"
                      >
                        <datepicker
                          autoApply
                          keepActionRow
                          :closeOnAutoApply="false"
                          v-model="model.job_publish_start_date"
                          :monthChangeOnScroll="false"
                          locale="ja"
                          ref="job_publish_end_date"
                          :maxDate="
                            model.job_publish_end_date
                              ? new Date(model.job_publish_end_date)
                              : null
                          "
                          :maxTime="setMaxTime()"
                          name="job_publish_start_date"
                          selectText="選択"
                          cancelText="閉じる"
                          class="width-200"
                          format="yyyy/MM/dd HH:mm"
                        />
                      </Field>
                      <ErrorMessage
                        class="error"
                        name="job_publish_start_date"
                      />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >公開終了日</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        as="div"
                        name="job_publish_end_date"
                        v-model="model.job_publish_end_date"
                        rules="required"
                      >
                        <datepicker
                          autoApply
                          keepActionRow
                          :closeOnAutoApply="false"
                          v-model="model.job_publish_end_date"
                          :monthChangeOnScroll="false"
                          locale="ja"
                          name="job_publish_end_date"
                          :minTime="setMinTime()"
                          :minDate="
                            model.job_publish_start_date
                              ? new Date(model.job_publish_start_date)
                              : null
                          "
                          selectText="選択"
                          cancelText="閉じる"
                          class="width-200"
                          format="yyyy/MM/dd HH:mm"
                        />
                      </Field>

                      <ErrorMessage class="error" name="job_publish_end_date" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >公開設定</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Toggle
                        name="job_publish_status"
                        v-model="model.job_publish_status"
                        on-label="公開"
                        off-label="非公開"
                      />
                    </div>
                  </CRow>
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
import Toggle from "@vueform/toggle";
import "@vueform/toggle/themes/default.css";

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
  },
  props: ["data"],
  mounted() {
    if (this.data.isEdit) {
      this.model.job_code = this.data.jobInfo.job_code;
      this.model.job_name = this.data.jobInfo.job_name;
      this.model.job_cost_start = this.data.jobInfo.job_cost_start;
      this.model.job_cost_end = this.data.jobInfo.job_cost_end;
      this.model.job_match_skill = this.data.jobInfo.job_match_skill;
      this.model.work_content = this.data.jobInfo.work_content;
      this.model.job_period = this.data.jobInfo.job_period;
      this.model.type_of_job = this.data.jobInfo.type_of_job;
      this.model.office_towns = this.data.jobInfo.office_towns;
      this.model.job_publish_start_date =
        this.data.jobInfo.job_publish_start_date;
      this.model.job_publish_end_date = this.data.jobInfo.job_publish_end_date;
      this.model.job_publish_status = this.data.jobInfo.job_publish_status
        ? true
        : false;
      this.model.genres = this.data.genreMasterList;
      this.model.areas = this.data.areaMasterList;
      this.model.skills = this.data.skillWordMasterList;
      this.model.desired_costs = this.data.desiredJobCostList;
      this.model.features = this.data.jobFeatureList;
    }

    $(document).on("click", ".input-area", function () {
      let isChecked = $(this).is(":checked");
      let areaId = $(this).attr("value");
      $(".input-pref").each(function () {
        if ($(this).attr("area-id") == areaId) {
          if (isChecked) {
            $(this).prop("checked", true);
          } else {
            $(this).prop("checked", false);
          }
        }
      });
    });
    let that = this;
    $(document).on('click', '.input-pref', function() {
      let areaId = $(this).attr("area-id");
      let countChecked = 0;
      let infoArea = that.data.areaMasters.find(x => x.id == areaId);
      $(".input-pref").each(function () {
        if ($(this).attr("area-id") == areaId) {
          if ($(this).is(':checked')) {
            countChecked++;
          }
        }
      });
      if (infoArea.area_prefectures.length == countChecked) {
        $(this).closest('.form-area').find('.input-area').prop('checked', true);
      } else {
        $(this).closest('.form-area').find('.input-area').prop('checked', false);
      }
    })
    $(function() {
      $(".input-area").each(function () {
        let isChecked = $(this).is(":checked");
        let areaId = $(this).attr("value");
        $(".input-pref").each(function () {
          if ($(this).attr("area-id") == areaId) {
            if (isChecked) {
              $(this).prop("checked", true);
            }
          }
        });
      });
    })
  },
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: {
        job_publish_status: true,
        type_of_job: 0,
        genres: [],
        areas: [],
        skills: [],
        desired_costs: [],
        features: [],
        prefectures: [],
      },
    };
  },
  created() {
    let messError = {
      en: {
        fields: {
          job_code: {
            required: "案件コードを入力してください",
            max: "案件コードは255文字以内で入力してください",
            unique_custom: "この案件コードは既に登録されています",
            job_code_rule:
              "案件コードは半角英数字で、大文字、小文字、数字で入力してください ",
          },
          job_name: {
            required: "案件名を入力してください",
            max: "案件名は255文字以内で入力してください",
          },
          job_cost_start: {
            required: "契約金額（税込）を入力してください",
            max: "契約金額（税込）は255文字以内で入力してください",
          },
          job_cost_end: {
            max: "契約金額（税込）は255文字以内で入力してください",
          },
          work_content: {
            max: "作業内容は20000文字以内で入力してください",
          },
          job_match_skill: {
            max: "必要スキルは20000文字以内で入力してください",
          },
          job_period: {
            max: "期間は255文字以内で入力してください",
          },
          office_towns: {
            max: "担当者コメントは20,000文字以内で入力してください",
          },
          job_publish_start_date: {
            required: "公開開始日を入力してください",
          },
          job_publish_end_date: {
            required: "公開終了日を入力してください",
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
        .post(that.data.urlCheckCode, {
          _token: Laravel.csrfToken,
          value: value,
          id: that.data.jobInfo ? that.data.jobInfo.id : "",
        })
        .then(function (response) {
          return response.data.valid;
        })
        .catch((error) => {});
    });
  },
  methods: {
    setMaxTime() {
      if (
        this.model.job_publish_end_date &&
        this.model.job_publish_start_date
      ) {
        let dateStart = new Date(this.model.job_publish_start_date);
        let dateEnd = new Date(this.model.job_publish_end_date);
        if (
          dateStart.getFullYear() == dateEnd.getFullYear() &&
          dateStart.getMonth() == dateEnd.getMonth() &&
          dateStart.getDate() == dateEnd.getDate()
        ) {
          return {
            hours: dateEnd.getHours(),
            minutes: dateEnd.getMinutes(),
          };
        }
      }
      return null;
    },
    setMinTime() {
      if (
        this.model.job_publish_end_date &&
        this.model.job_publish_start_date
      ) {
        let dateStart = new Date(this.model.job_publish_start_date);
        let dateEnd = new Date(this.model.job_publish_end_date);
        if (
          dateStart.getFullYear() == dateEnd.getFullYear() &&
          dateStart.getMonth() == dateEnd.getMonth() &&
          dateStart.getDate() == dateEnd.getDate()
        ) {
          return {
            hours: dateStart.getHours(),
            minutes: dateStart.getMinutes(),
          };
        }
      }
      return null;
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
    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formData.submit();
    },
  },
};
</script>
