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
                :action="data.urlUpdate"
                ref="formData"
              >
                <Field type="hidden" :value="csrfToken" name="_token" />
                <Field type="hidden" value="PUT" name="_method" />
                <CCardHeader>
                  <CFormLabel>{{ data.title }}</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >エリア名</CFormLabel
                    >
                    <div class="col-sm-4">
                      <Field
                        as="select"
                        name="area_id"
                        placeholder=""
                        @change="changeArea"
                        v-model="model.area_id"
                        class="form-select"
                      >
                        <option
                          v-for="item in data.areaSelect"
                          :key="item.id"
                          :value="item.id"
                          :selected="model.area_id == item.id"
                        >
                          {{ item.name }}
                        </option>
                      </Field>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input"
                      >都道府県名称</CFormLabel
                    >
                    <div class="col-sm-9">
                      <CRow>
                        <div
                          class="col-sm-3"
                          v-for="item in prefecture"
                          :key="item.id"
                        >
                          <Field
                            as="div"
                            name="prefectures"
                            v-model="model.prefectures"
                            class="form-check form-check-inline"
                          >
                            <input
                              name="prefectures[]"
                              class="form-check-input"
                              :id="'prefectures' + item.id"
                              type="checkbox"
                              :value="item.id"
                              :checked="model.area_prefectures.find(x => x.prefecture_id == item.id) ? true : false"
                            />
                            <label
                              class="form-check-label"
                              :for="'prefectures' + item.id"
                              >{{ item.prefecture_name }}</label
                            >
                          </Field>
                        </div>
                      </CRow>
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >ソート順序</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="order_number"
                        v-model="model.order_number"
                        rules="required|number"
                        class="form-control"
                        type="number"
                      />
                      <ErrorMessage class="error" name="order_number" />
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
    Toggle
  },
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: this.data.item,
      type : this.data.type,
      prefecture: [],
    };
  },
  created() {
    let messError = {
      en: {
        fields: {
          area_name: {
            required: "エリア名を入力してください",
            max: "エリア名は255文字以内で入力してください",
          },
          order_number: {
            required: "ソート順序を入力してください",
            number: "半角数字を入力してください",
          }
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });
    let that = this;
  },
  mounted() {
    this.changeArea();
  },
  methods: {
    changeArea() {
      this.prefecture = this.data.prefectures.filter(
        (x) => x.area_id == this.model.area_id
      );
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
