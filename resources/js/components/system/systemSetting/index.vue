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
                  <CFormLabel>システム設定</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow class="mb-2">
                    <CFormLabel class="col-sm-3 lbl-input" require
                      >差出人メールアドレス</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Field
                        name="system_email"
                        type="text"
                        autocomplete="new-password"
                        v-model="model.system_email"
                        placeholder="taro@example.jp"
                        rules="required|email"
                        class="form-control"
                      />
                      <ErrorMessage class="error" name="system_email" />
                    </div>
                  </CRow>
                </CCardBody>
                <CCardFooter>
                  <div class="col-md-12 text-center btn-box">
                    <CButton type="submit" class="btn-primary btn-w-100">
                      登録
                    </CButton>
                    <!-- <a :href="data.urlBack" class="btn btn-default btn-w-100">
                      キャンセル
                    </a> -->
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
  },
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: this.data.systemSettingInfo
    };
  },
  created() {
    let messError = {
      en: {
        fields: {
          system_email: {
            required: "差出人メールアドレスを入力してください。",
            email: "差出人メールアドレスを正確に入力してください。",
          },
        },
      },
    };
    configure({
      generateMessage: localize(messError),
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
