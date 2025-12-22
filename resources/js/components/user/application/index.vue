<template>
  <div class="application-page word-break">
    <div class="container application-container">
      <div class="header-title">
        <h2 class="application-title">今すぐお申し込み</h2>
      </div>
      <div
        class="
          application-content
          d-flex
          justify-content-between
          align-items-start
          flex-wrap
          m-t-32
        "
      >
        <div class="application-left">
          <h3 class="content-title">{{ data.jobInfo.job_name }}</h3>
          <p class="app-subtitle">契約金額（税込）</p>
          <p class="app-price">{{ data.jobInfo.job_cost_start.replaceAll('〜', '') }}～{{ data.jobInfo.job_cost_end }}</p>
          <button @click="favorite" class="btn btn-add-favorite">
            <span class="btn-txt d-inline-block">{{
              isFavorite ? "お気に入りから外す" : "お気に入りに追加"
            }}</span>
          </button>
        </div>
        <div class="application-right">
          <div class="application-table">
            <div class="application-row">
              <span>作業内容</span>
              <nl2br v-if="data.jobInfo.work_content" tag="span" :text="data.jobInfo.work_content" class="nl2br"/>
            </div>
            <div class="application-row">
              <span>必要スキル</span>
              <nl2br v-if="data.jobInfo.job_match_skill" tag="span" :text="data.jobInfo.job_match_skill" class="nl2br"/>
            </div>
          <div class="application-row">
            <span>特徴</span>
            <span>{{ data.featureTxt }}</span>
          </div>
            <div class="application-row">
              <span>勤務地</span>
              <span>
                <template v-for="item in data.dataAddress" :key="item.area_name">
                  {{ item.area_name }}{{ item.pref_name ? ('(' + item.pref_name + ')') : '' }}<br>
                </template>
              </span>
            </div>
            <div class="application-row">
              <span>期間</span>
              <span>{{ data.jobInfo.job_period }}</span>
            </div>
            <div class="application-row">
              <span>契約形態</span>
              <span>{{ data.jobInfo.type_of_job ? "派遣" : "共同受注" }}</span>
            </div>
            <div class="application-row">
              <span>担当者コメント</span>
              <nl2br v-if="data.jobInfo.office_towns" tag="span" :text="data.jobInfo.office_towns" class="nl2br"/>
            </div>
          </div>
          <div class="application-btn d-flex justify-content-center justify-content-sm-start">
            <a
              :href="'/search/' + data.jobInfo.id"
              class="
                btn btn-app btn-back
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <img
                src="/assets/img/user/ic_arrow_left.svg"
                class="ic-arrow ic-arrow-left"
                alt=""
              />
              <span class="ic-txt d-inline-block event-link">条件をクリア</span>
            </a>
            <form method="POST" :action="data.urlRegisterJob" class="form-btn">
              <input type="hidden" name="_method" value="PUT" />
              <input type="hidden" :value="csrfToken" name="_token" />
              <button
                href="/application-complete"
                class="
                  btn btn-app btn-goto-application
                  d-flex
                  align-items-center
                  justify-content-center
                "
                style="width: 100%;"
              >
                <span class="ic-txt d-inline-block">申し込む</span>
                <img
                  src="/assets/img/user/ic_arrow_right_white.svg"
                  class="ic-arrow ic-arrow-right"
                  alt=""
                />
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<script>
import Loader from "../../common/loader.vue";
import Nl2br from 'vue3-nl2br';
export default {
  components: {
    Loader,
    Nl2br
  },
  data() {
    return {
      flagShowLoader: false,
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
      isFavorite: this.data.jobInfo.favorite,
    };
  },
  props: ["data"],
  methods: {
    favorite() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .post("/favorite", {
          _token: Laravel.csrfToken,
          job_id: that.data.jobInfo.id,
        })
        .then(function (res) {
          that.flagShowLoader = false;
          $(".img-icon-favorite").each(function () {
            if ($(this).attr("data-id") == that.data.jobInfo.id) {
              if (that.isFavorite) {
                $(this).prop("src", "/assets/img/user/icon_non_bookmark.svg");
              } else {
                $(this).prop("src", "/assets/img/user/ic_bookmark.svg");
              }
            }
          });
          if (res.data.status == 200) {
            that.isFavorite = that.isFavorite ? "" : 1;
          }
        })
        .catch((error) => {});
    },
    getTxt(index) {
      let txt = [];
      let that = this;
      switch (index) {
        case 1:
          if (this.data.jobInfo.skills) {
            this.data.jobInfo.skills.forEach((element) => {
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
          if (this.data.jobInfo.areas) {
            this.data.jobInfo.areas.forEach((element) => {
              let findItemMaster = that.data.areaMasters.find(
                (x) => x.id == element.id
              );
              if (findItemMaster) {
                txt.push(findItemMaster.area_name);
              }
            });
          }
          break;
        case 3:
          if (this.job.skills) {
            this.job.skills.forEach((element) => {
              let findItemMaster = that.data.skillWordMasters.find(
                (x) => x.id == element.id
              );
              if (findItemMaster) {
                txt.push(findItemMaster.skill_name);
              }
            });
          }
          break;
      }
      return txt.join(", ");
    },
  },
};
</script>

<style>
</style>