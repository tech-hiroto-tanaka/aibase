<template>
  <CCard class="mb-3">
    <CCardHeader>
      <CFormLabel>配信条件</CFormLabel>
    </CCardHeader>
    <CCardBody>
      <CRow class="mb-2">
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">ユーザー名</CFormLabel>
            <div class="col-sm-8">
              <Field
                name="mail_condition[name]"
                v-model="conditionsModel.name"
                class="form-control"
              />
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">フリガナ</CFormLabel>
            <div class="col-sm-8">
              <Field
                name="mail_condition[name_furigana]"
                v-model="conditionsModel.name_furigana"
                class="form-control"
              />
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">性別</CFormLabel>
            <div class="col-sm-8">
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input mail_condition-male"
                  type="checkbox"
                  id="mail_condition[gender_male]"
                  name="mail_condition[gender][]"
                  :checked="
                    Array.isArray(conditionsModel.gender) &&
                    conditionsModel.gender.includes('1')
                  "
                  value="1"
                />
                <label
                  class="form-check-label"
                  for="mail_condition[gender_male]"
                  >男性</label
                >
              </div>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input mail_condition-female"
                  type="checkbox"
                  id="mail_condition[gender_female]"
                  name="mail_condition[gender][]"
                  :checked="
                    Array.isArray(conditionsModel.gender) &&
                    conditionsModel.gender.includes('2')
                  "
                  value="2"
                />
                <label
                  class="form-check-label"
                  for="mail_condition[gender_female]"
                  >女性</label
                >
              </div>
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">生年月日</CFormLabel>
            <div class="col-sm-8">
              <Field
                as="div"
                name="mail_condition[birthday]"
                v-model="conditionsModel.birthday"
              >
                <datepicker
                  autoApply
                  keepActionRow
                  :closeOnAutoApply="false"
                  v-model="conditionsModel.birthday"
                  :monthChangeOnScroll="false"
                  locale="ja"
                  name="mail_condition[birthday]"
                  selectText="選択"
                  cancelText="閉じる"
                  class="width-200"
                  format="yyyy/MM/dd"
                  :enableTimePicker="false"
                />
              </Field>
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">メールアドレス</CFormLabel>
            <div class="col-sm-8">
              <Field
                name="mail_condition[email]"
                v-model="conditionsModel.email"
                class="form-control"
              />
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">ご連絡先電話番号</CFormLabel>
            <div class="col-sm-8">
              <Field
                name="mail_condition[phone_number]"
                v-model="conditionsModel.phone_number"
                class="form-control"
              />
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">お住いのエリア</CFormLabel>
            <div class="col-sm-8">
              <div
                class="form-group d-inline-block mr-4"
                v-for="(item, index) in data.areas"
                :key="item.id"
              >
                <input
                  type="checkbox"
                  name="mail_condition[area][]"
                  :value="item.id"
                  :id="'area_' + index"
                  :checked="
                    Array.isArray(conditionsModel.area) &&
                    conditionsModel.area.includes(item.id.toString())
                  "
                  class="form-check-input check-area"
                  :data-txt="item.area_name"
                />
                <label :for="'area_' + index" class="ms-2">{{
                  item.area_name
                }}</label>
              </div>
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">希望就業時期</CFormLabel>
            <div class="col-sm-8">
              <div
                class="form-group d-inline-block mr-4"
                v-for="(item, index) in data.desiredWorkType"
                :key="item.id"
              >
                <input
                  type="checkbox"
                  name="mail_condition[desired_work_type][]"
                  :checked="
                    Array.isArray(conditionsModel.desired_work_type) &&
                    conditionsModel.desired_work_type.includes(item.id.toString())
                  "
                  :value="item.id"
                  :id="'desired_work_type_' + index"
                  class="form-check-input check-desire"
                  :data-txt="item.label"
                />
                <label :for="'desired_work_type_' + index" class="ms-2">{{
                  item.label
                }}</label>
              </div>
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">経験スキル</CFormLabel>
            <div class="col-sm-8">
              <Field
                name="mail_condition[experience_skills_detail]"
                v-model="conditionsModel.experience_skills_detail"
                class="form-control"
              />
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">最寄駅</CFormLabel>
            <div class="col-sm-8">
              <Field
                name="mail_condition[nearest_station_name]"
                v-model="conditionsModel.nearest_station_name"
                class="form-control"
              />
            </div>
          </CRow>
        </div>
        <div class="col-6">
          <CRow class="mb-2">
            <CFormLabel class="col-sm-4 lbl-input">その他ご要望</CFormLabel>
            <div class="col-sm-8">
              <Field
                name="mail_condition[other_requests]"
                v-model="conditionsModel.other_requests"
                class="form-control"
              />
            </div>
          </CRow>
        </div>
      </CRow>
    </CCardBody>
    <CCardFooter v-if="data.isSearch">
      <div class="col-md-12 text-center btn-box">
        <CButton type="submit" class="btn-primary btn-w-100">
          <i class="fa fa-search"></i> &nbsp; 検索
        </CButton>
        <!-- <CButton type="button" class="btn-primary btn-w-100" @click="redirectMail">
          検索結果にメールを配信
        </CButton> -->
        <CButton type="button" @click="clearCondition" class="btn-default btn-w-100 btn-clear">
          クリア
        </CButton>
      </div>
    </CCardFooter>
    <CCardFooter v-else>
      <div class="col-md-12 text-center btn-box">
        <CButton type="button" @click="clearCondition" class="btn-default btn-w-100 btn-clear">
          クリア
        </CButton>
      </div>
    </CCardFooter>
  </CCard>
</template>

<script>
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
export default {
  setup() {
    Object.keys(rules).forEach((rule) => {
      if (rule != "default") {
        defineRule(rule, rules[rule]);
      }
    });
  },
  mounted() {
    let that = this;
    $(document).on('click', '.btn-redirect', function() {
      that.redirectMail();
    })
  },
  components: {
    VeeForm,
    Field,
    ErrorMessage,
    Datepicker,
  },
  data: function () {
    return {
      conditionsModel: this.conditions ?? {},
    };
  },
  props: ["conditions", "data"],
  methods: {
    clearCondition() {
      $('.form-check-input').prop('checked', false);
      this.conditionsModel = {};
    },
    redirectMail() {
      $('#form-search').attr('action', this.data.routeMail);
      setTimeout(function() {
        $('#form-search').submit();
      }, 1000);
    }
  }
};
</script>

<style>
</style>