require('./bootstrap');
import { createApp } from "vue";
import $ from "jquery";
import { configure, defineRule } from "vee-validate";
configure({
    validateOnBlur: false,
    validateOnChange: false,
    validateOnInput: true,
    validateOnModelUpdate: false,
});
const app = createApp({});
// app.use(CoreuiVue);
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
app.use(VueSweetalert2);

$(function() {
  $('.show-loaded').removeClass('show-loaded');
})

defineRule('password_rule', value => {
    return /^[A-Za-z0-9!-/:-@¥[-`{-~\]]*$/i.test(value);
});
defineRule('furigana', value => {
    return /^[一-龥ぁ-ん]*$/i.test(value);
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
defineRule('format_day', function(value, arg) {
    if (arg.length && !value) {
        return true;
    }
    if (!value) {
        return true;
    }
    let checkFormat = /^[0-9]{4}\/([1-9]|0[1-9]|1[0-2])\/([1-9]|0[1-9]|[1-2][0-9]|3[0-1])$/i.test(value);
    if (!checkFormat) {
        return false;
    }
    let date = new Date(value);
    let dateSplit = value.split('/');
    return date.getFullYear() == parseInt(dateSplit[0]) && (date.getMonth() + 1) == parseInt(dateSplit[1]) && date.getDate() == parseInt(dateSplit[2]);
});
defineRule('same', (value, target) => {
    return $('#' + target[0]).val() == value.trim()
});

import BtnDeleteConfirm from "./components/common/btnDeleteConfirm.vue";
import DataEmpty from "./components/common/dataEmpty.vue";
import PopupAlert from "./components/common/popupAlert.vue";
import LimitPageOption from "./components/common/limitPageOption.vue";
import Register from "./components/user/register/index.vue";
import DoneRegister from "./components/user/register/done.vue";
import Login from "./components/user/login/index.vue";
import VerifySuccess from "./components/user/register/verifySuccess.vue";
import CompanyContactCreate from "./components/companyContact/create.vue";
import FavoriteItem from "./components/common/itemFavorite.vue";
import Top from "./components/user/top/index.vue";
import Search from "./components/user/search/index.vue";
import JobSlider from "./components/common/jobSlider.vue";
import Contact from "./components/user/contact/index.vue";
import TermsOfService from "./components/user/termsOfService/index.vue";
import FavoriteList from "./components/user/favorite/index.vue";
import CompanyProfile from "./components/user/companyProfile/index.vue";
import Profile from "./components/user/profile/index.vue";
import FavoriteModal from "./components/common/favoriteModal.vue";
import UserForgotPassword from "./components/user/forgotPassword/index.vue";
import UserPasswordReset from "./components/user/passwordReset/show.vue";
import UserForgotPasswordSuccess from "./components/user/forgotPasswordSuccess/index.vue";
import JobInfo from "./components/user/job/jobInfo.vue";
import Application from "./components/user/application/index.vue";
import Policy from "./components/user/policy/index.vue";
import SearchModal from "./components/common/searchModal.vue";
import ContactSuccess from "./components/user/contact/success.vue";

app.component("btn-delete-confirm", BtnDeleteConfirm);
app.component("data-empty", DataEmpty);
app.component("popup-alert", PopupAlert);
app.component("limit-page-option", LimitPageOption);
app.component("register", Register);
app.component("done-register", DoneRegister);
app.component("login", Login);
app.component("verify-success", VerifySuccess);
app.component("company-contact-create", CompanyContactCreate);
app.component("favorite", FavoriteItem);
app.component("top", Top);
app.component("search", Search);
app.component("job-slider", JobSlider);
app.component("contact", Contact);
app.component("terms-of-service", TermsOfService);
app.component("favorite-list", FavoriteList);
app.component("company-profile", CompanyProfile);
app.component("profile", Profile);
app.component("favorite-modal", FavoriteModal);
app.component("user-forgot-password", UserForgotPassword);
app.component("user-password-reset", UserPasswordReset);
app.component("user-forgot-password-success", UserForgotPasswordSuccess);
app.component("job-info", JobInfo);
app.component("application", Application);
app.component("policy", Policy);
app.component("search-modal", SearchModal);
app.component("contact-success", ContactSuccess);

app.mount("#app");
