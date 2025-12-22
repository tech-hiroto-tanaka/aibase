<template>
  <div class="word-break">
    <div class="s-detail-header job-detail-tag">
      <h3 class="content-title">{{ data.jobInfo.job_name }}</h3>
      <div class="tag-list" v-if="data.tags.length">
        <div class="tag-item" v-for="item in data.tags" :key="item">{{item}}</div>
      </div>
      <p class="app-subtitle">契約金額（税込）</p>
      <div class="d-flex align-items-center flex-wrap">
        <span class="app-price">{{ data.jobInfo.job_cost_start.replaceAll('〜', '') }}～{{ data.jobInfo.job_cost_end }}</span>
        <button
          @click="favorite"
          class="
            btn btn-app btn-add-favorite
            d-flex
            justify-content-center
            align-items-center
            mt-s3-0
          "
        >
          <span class="btn-txt d-inline-block">{{
            isFavorite ? "お気に入りから外す" : "お気に入りに追加"
          }}</span>
          <img src="/assets/img/user/ic_arrow_right_white.svg" />
        </button>
      </div>
    </div>
    <div class="s-detail-body">
      <div class="application-table s-app-table">
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

<style></style>
