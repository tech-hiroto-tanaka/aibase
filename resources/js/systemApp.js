import {
    createApp
} from "vue";
import CoreuiVue from "@coreui/vue";
import $ from 'jquery'
import {
    configure,
    defineRule
} from "vee-validate";
configure({
    validateOnBlur: false,
    validateOnChange: false,
    validateOnInput: true,
    validateOnModelUpdate: false,
});
const app = createApp({});
app.use(CoreuiVue);
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
app.use(VueSweetalert2);

defineRule('password_rule', value => {
  return /^[A-Za-z0-9!-/:-@¥[-`{-~\]]*$/i.test(value);
});
defineRule('job_code_rule', value => {
    return /^[A-Za-z0-9!-/:-@¥[-`{-~\]]*$/i.test(value);
});
defineRule('hiragana', value => {
    return /^[ぁ-ん]*$/i.test(value);
});
defineRule('katakana', value => {
    return /^([ァ-ン]|ー)*$/i.test(value);
});
defineRule('telephone', value => {
  return /^0(\d-\d{4}-\d{4})+$/i.test(value.trim()) ||
    /^0(\d{3}-\d{2}-\d{4})+$/i.test(value.trim()) ||
    /^(070|080|090|050)(-\d{4}-\d{4})+$/i.test(value.trim()) ||
    /^0(\d{2}-\d{3}-\d{4})+$/i.test(value.trim()) ||
    /^0(\d{9})+$/i.test(value.trim()) ||
    /^(070|080|090|050)(\d{8})+$/i.test(value.trim())
});

defineRule('number', value => {
    return /^\d*$/i.test(value);
});

defineRule('compare_date', function(value, [target], ctx) {
    if (!ctx.form[target]) {
        return true;
    }
    return (new Date(value) <= (new Date(ctx.form[target])));
}, {
    hasTarget: true
});
$(document).on('click', '.header-search', function() {
    let eleI = $(this).find(".fa-arrow-down");
    let collapse = $(this).closest('.card-search').find('.body-search');
    if (collapse.is(":visible")) {
        eleI.css({
            transition: "0.2s",
            transform: "rotate(0deg)",
        });
    } else {
        eleI.css({
            transition: "0.2s",
            transform: "rotate(180deg)",
        });
    }
    collapse.slideToggle(300);
});

$(document).ready(function() {
    if ($('.header-search').hasClass('show')) {
        $('.header-search').trigger('click');
    }
});


import BtnDeleteConfirm from "./components/common/btnDeleteConfirm.vue";
import BtnDeleteMulti from "./components/common/btnDeleteMulti.vue";
import DataEmpty from "./components/common/dataEmpty.vue";
import PopupAlert from "./components/common/popupAlert.vue";
import LimitPageOption from "./components/common/limitPageOption.vue";
import Login from "./components/system/login/index.vue";
import ForgotPassword from "./components/system/forgotPassword/index.vue";

import NewCreate from "./components/system/new/create.vue";
import NewEdit from "./components/system/new/edit.vue";
import UserCreate from "./components/system/user/create.vue";
import UserEdit from "./components/system/user/edit.vue";
import ItemMasterCreate from "./components/system/itemMaster/create.vue";
import ItemMasterEdit from "./components/system/itemMaster/edit.vue";
import GenreCreate from "./components/system/genre/create.vue";
import GenreEdit from "./components/system/genre/edit.vue";
import AreaCreate from "./components/system/area/create.vue";
import AreaEdit from "./components/system/area/edit.vue";
import SkillCreate from "./components/system/skill/create.vue";
import SkillEdit from "./components/system/skill/edit.vue";
import DesiredCostCreate from "./components/system/desiredCost/create.vue";
import DesiredCostEdit from "./components/system/desiredCost/edit.vue";
import FeatureCreate from "./components/system/feature/create.vue";
import FeatureEdit from "./components/system/feature/edit.vue";
import JobCreate from "./components/system/job/create.vue";
import CompanyContactEdit from "./components/system/companyContact/edit.vue";

import ContactEdit from "./components/system/contact/edit.vue";
import JobContactDetail from "./components/system/jobContact/detail.vue";
import MailTemplate from "./components/system/mailTemplate/form.vue";
import MailSchedule from "./components/system/mailSchedule/form.vue";
import Search from "./components/system/mailSchedule/search.vue";
import SystemSetting from "./components/system/systemSetting/index.vue";

import { date } from "yup";


app.component("btn-delete-confirm", BtnDeleteConfirm);
app.component("btn-delete-multi", BtnDeleteMulti);
app.component("data-empty", DataEmpty);
app.component("popup-alert", PopupAlert);
app.component("limit-page-option", LimitPageOption);
app.component("login", Login);
app.component("forgot-password", ForgotPassword);

app.component("new-create", NewCreate);
app.component("new-edit", NewEdit);
app.component("user-create", UserCreate);
app.component("user-edit", UserEdit);
app.component("item-master-create", ItemMasterCreate);
app.component("item-master-edit", ItemMasterEdit);
app.component("genre-create", GenreCreate);
app.component("genre-edit", GenreEdit);
app.component("area-create", AreaCreate);
app.component("area-edit", AreaEdit);
app.component("skill-create", SkillCreate);
app.component("skill-edit", SkillEdit);
app.component("desired-cost-create", DesiredCostCreate);
app.component("desired-cost-edit", DesiredCostEdit);
app.component("feature-create", FeatureCreate);
app.component("feature-edit", FeatureEdit);
app.component("job-create", JobCreate);
app.component("contact-edit", ContactEdit);
app.component("company-contact-edit", CompanyContactEdit);
app.component("job-contact-detail", JobContactDetail);
app.component("mail-template", MailTemplate);
app.component("mail-schedule", MailSchedule);
app.component("search", Search);
app.component("system-setting", SystemSetting);

app.mount("#app");
