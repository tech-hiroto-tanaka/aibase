<template>
  <div class="container">
    <div class="fade-in">
      <CRow>
        <CCol :sm="12">
          <CCard>
            <VeeForm as="div" v-slot="{ handleSubmit }">
              <form
                method="POST"
                @submit="handleSubmit($event, onSubmit)"
                :action="data.urlUpdate"
                ref="formData"
              >
                <Field type="hidden" :value="csrfToken" name="_token" />
                <Field type="hidden" value="PUT" name="_method" />
                <CCardHeader>
                  <CFormLabel>連絡先の詳細</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">
                      メールアドレス:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">
                        {{ jobContact.email }}
                      </CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">
                      案件コード:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        jobContact.code
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"> 案件名:</CFormLabel>
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        jobContact.job_name
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">
                      契約金額（税込）:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br"
                        >{{ jobContact.cost_start }}～{{
                          jobContact.cost_end
                        }}</CFormLabel
                      >
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">
                      勤務地 :</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br" v-html="getTxt(2)"></CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">
                      必要スキル :</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br" v-html="getTxt(1)"></CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">
                      公開開始日:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        formatFullDate(jobContact.start_date)
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">
                      公開終了日:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        formatFullDate(jobContact.end_date)
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >登録時間:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        formatFullDate(jobContact.created)
                      }}</CFormLabel>
                    </div>
                  </CRow>

                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >ステータス:</CFormLabel
                    >
                    <div class="col-sm-3">
                      <Field
                        as="select"
                        name="status"
                        v-model="model.status"
                        class="form-select"
                      >
                        <option
                          v-for="data in data.contactTypes"
                          :key="data.id"
                          :value="data.id"
                        >
                          <!-- :checked="data.id == model.status" -->
                          {{ data.label }}
                        </option>
                      </Field>
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

import { Form as VeeForm, Field } from "vee-validate";

export default {
  setup() {},
  components: {
    Loader,
    VeeForm,
    Field,
  },

  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      jobContact: this.data.jobContact,
      skills: this.data.jobContact.skills,
      areas: this.data.jobContact.areas,
      model: this.data.jobContact,
    };
  },
  created() {},

  methods: {
    getTxt(index) {
      let txt = [];
      let that = this;
      switch (index) {
        case 1:
          if (this.data.jobContact.skills) {
            let skills = JSON.parse(this.data.jobContact.skills);
            skills.forEach((element) => {
              let findItemMaster = that.data.skillWordMasters.find(
                (x) => x.id == element.id
              );
              if (findItemMaster) {
                txt.push(findItemMaster.skill_name);
              }
            });
          }
          break;
        case 2:
          if (this.data.jobContact.areas) {
            let areas = JSON.parse(this.data.jobContact.areas);
            areas.forEach((element) => {
              let findItemMaster = that.data.areaMasters.find(
                (x) => x.id == element.id
              );
              if (findItemMaster) {
                txt.push(findItemMaster.area_name);
              }
            });
          }
          break;
      }
      return txt.join(", ");
    },
    formatFullDate(day) {
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
        (d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes()) +
        ":" +
        (d.getSeconds() < 10 ? "0" + d.getSeconds() : d.getSeconds())
      );
    },

    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formData.submit();
    },
  },
};
</script>
