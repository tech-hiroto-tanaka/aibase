<template>
  <div>
    <button class="btn btn-primary btn-delete-muli" disabled @click="showAlert" style="cursor: pointer">
      <i class="fa fa-trash" aria-hidden="true"></i>
      選択したデータを削除
    </button>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<script>
import Loader from "./loader.vue";
import axios from "axios";
import $ from "jquery";

export default {
  data() {
    return {
      flagShowLoader: false,
    };
  },
  components: {
    Loader,
  },
  props: ["deleteAction", "listUrl", "messageConfirm"],
  mounted() {
    let that = this;
    $(document).on("change", ".check-all-delete", function () {
      $(".check-item-delete").prop("checked", false);
      if ($(this).is(":checked")) {
        $(".check-item-delete").prop("checked", true);
      }
      that.enableBtn();
    });
    $(document).on("change", ".check-item-delete", function () {
      $(".check-all-delete").prop("checked", false);
      if (
        $(".check-item-delete:checked").length ==
        $(".check-item-delete").length
      ) {
        $(".check-all-delete").prop("checked", true);
      }
      that.enableBtn();
    });
  },
  methods: {
    enableBtn() {
      $('.btn-delete-muli').prop('disabled', true);
      if ($(".check-item-delete:checked").length) {
        $('.btn-delete-muli').prop('disabled', false);
      }
    },
    showAlert() {
      let that = this;
      let ids = [];
      $(".check-item-delete:checked").each(function() {
        ids.push($(this).attr('data-id'));
      })
      this.$swal({
        title: that.messageConfirm,
        icon: "warning",
        confirmButtonText: "削除する",
        cancelButtonText: "閉じる",
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          that.flagShowLoader = true;
          $(".loading-div").removeClass("hidden");
          axios
            .delete(that.deleteAction, {
              _token: Laravel.csrfToken,
              data: {
                ids: ids
              }
            })
            .then(function (response) {
              that.flagShowLoader = false;
              $(".loading-div").addClass("hidden");
              that
                .$swal({
                  title: response.data.message,
                  icon: "success",
                  confirmButtonText: "閉じる",
                })
                .then(function () {
                  //   window.location.href = that.listUrl;
                  location.reload();
                });
            })
            .catch((error) => {
              that.flagShowLoader = false;
            });
        }
      });
    },
  },
};
</script>
