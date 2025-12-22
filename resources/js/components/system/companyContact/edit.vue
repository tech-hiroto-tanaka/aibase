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
                  <CFormLabel>会社の問い合わせ詳細</CFormLabel>
                </CCardHeader>
                <CCardBody>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">会社名:</CFormLabel>
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        model.companyName
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">部署名:</CFormLabel>
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        model.departmentName
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input">お名前:</CFormLabel>
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br"
                        >{{ model.contactHiraFirstName }} -
                        {{ model.contactHiraLastName }}</CFormLabel
                      >
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >フリガナ:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br"
                        >{{ model.contactKataFirstName }} -
                        {{ model.contactKataLastName }}</CFormLabel
                      >
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >ご連絡先電話番号:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        model.contactPhoneNumber
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >メールアドレス:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        model.contactEmail
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >ご希望のエリア:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        model.contactArea
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >お問い合わせ内容:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <Nl2br
                        tag="label"
                        :text="model.contactContent"
                        class="form-label nl2br"
                      />
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >コンタクトエージェント:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="lbl-input text-left">{{
                        model.contactAgent
                      }}</CFormLabel>
                    </div>
                  </CRow>
                  <CRow>
                    <CFormLabel class="col-sm-3 lbl-input"
                      >連絡先IP:</CFormLabel
                    >
                    <div class="col-sm-6">
                      <CFormLabel class="nl2br">{{
                        model.contactIp
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
                        name="contact_type"
                        placeholder=""
                        v-model="model.contactType"
                        class="form-select"
                      >
                        <option
                          v-for="data in model.contactTypes"
                          :key="data.id"
                          :value="data.id"
                        >
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
import Nl2br from "vue3-nl2br";

export default {
  setup() {},
  components: {
    Loader,
    VeeForm,
    Field,
    Nl2br,
  },
  props: ["data"],
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      flagShowLoader: false,
      model: {
        companyName: this.data.companyContact.company_name,
        departmentName: this.data.companyContact.department_name,
        contactHiraFirstName: this.data.companyContact.contact_hira_first_name,
        contactHiraLastName: this.data.companyContact.contact_hira_last_name,
        contactKataFirstName: this.data.companyContact.contact_kata_first_name,
        contactKataLastName: this.data.companyContact.contact_kata_last_name,
        contactPhoneNumber: this.data.companyContact.contact_phone_number,
        contactEmail: this.data.companyContact.contact_email,
        contactContent: this.data.companyContact.contact_content,
        contactAgent: this.data.companyContact.contact_agent,
        contactIp: this.data.companyContact.contact_ip,
        contactType: this.data.companyContact.contact_type,
        contactArea: this.data.companyContact?.area_name,
        contactTypes: this.data.contactTypes,
      },
    };
  },
  created() {},
  methods: {
    onSubmit() {
      this.flagShowLoader = true;
      this.$refs.formData.submit();
    },
  },
};
</script>
