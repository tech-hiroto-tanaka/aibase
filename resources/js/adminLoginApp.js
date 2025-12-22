import {
  createApp
} from "vue";
import CoreuiVue from "@coreui/vue";
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

import BtnDeleteConfirm from "./components/common/btnDeleteConfirm.vue";
import DataEmpty from "./components/common/dataEmpty.vue";
import PopupAlert from "./components/common/popupAlert.vue";
import LimitPageOption from "./components/common/limitPageOption.vue";
import Login from "./components/system/login/index.vue";
import ForgotPassword from "./components/system/forgotPassword/index.vue";
import forgotPasswordSuccess from "./components/forgotPasswordSuccess/index.vue";
import PasswordReset from "./components/system/passwordReset/show.vue";

app.component("btn-delete-confirm", BtnDeleteConfirm);
app.component("data-empty", DataEmpty);
app.component("popup-alert", PopupAlert);
app.component("limit-page-option", LimitPageOption);
app.component("login", Login);
app.component("forgot-password", ForgotPassword);
app.component("forgot-password-success", forgotPasswordSuccess);
app.component("password-reset", PasswordReset);

app.mount("#app");
