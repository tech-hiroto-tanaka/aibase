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
                <CCardHeader>
                  <CFormLabel>{{ data.title }}</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >希望単価名</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="desired_cost_name"
                        v-model="model.desired_cost_name"
                        rules="required|max:255"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="desired_cost_name" />
                    </div>
                  </CRow>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >単価</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="money"
                        v-model="model.money"
                        rules="required|number|min_value:1"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="money" />
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
                        rules="required|number|min_value:1"
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
      model: {
        using_status: true,
        order_number: this.data.order
      },
      type : this.data.type
    };
  },
  created() {
    let messError = {
      en: {
        fields: {
          desired_cost_name: {
            required: "希望単価名を入力してください",
            max: "希望単価名は255文字以内で入力してください",
          },
          money: {
            required: "単価を入力してください",
            number: "全角数字を入力してください",
            min_value: "1以上の半角数字を入力してください"
          },
          order_number: {
            required: "ソート順序を入力してください",
            number: "全角数字を入力してください",
            min_value: "1以上の半角数字を入力してください"
          }
        },
      },
    };
    configure({
      generateMessage: localize(messError),
    });
    let that = this;
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
      this.$refs.formData.submit();
    },
  },
};
</script>
