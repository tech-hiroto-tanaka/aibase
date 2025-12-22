<template>
  <div
    class="favorite-card"
    @click="jobDetail"
    :class="{ 'favorite-card-search': data.isSearch }"
  >
    <div class="favorite-card-container">
      <div class="favorite-card-wrapper">
        <div class="favorite-card-header">{{ job.job_name }}</div>
        <div class="favorite-card-body d-flex flex-column justify-content-between">
          <div>
            <div class="content-item line-1" v-if="job.job_cost_start">
              <span class="label-txt">単価：</span>
              <span class="info-txt txt-price"
              >{{ job.job_cost_start.replaceAll('〜', '') }}～{{ job.job_cost_end }}</span
              >
            </div>
            <div class="content-item line-1">
              <span class="label-txt">勤務地：</span>
              <span class="info-txt txt-area">{{ getTxt(2) }}</span>
            </div>
            <div class="content-item line-1">
              <span class="label-txt">内容：</span>
              <span class="info-txt txt-area txt-content" v-html="convertNl2br(job.work_content)"></span>
            </div>
            <div class="content-item line-1">
              <span class="label-txt">スキル：</span>
              <span class="info-txt txt-area txt-skill" v-html="convertNl2br(job.job_match_skill)"></span>
            </div>
          </div>
          <div class="content-item feature-content line-1 tag-content-container">
            <div class="tag-list feature-tag-list">
              <div class="tag-item" v-for="(item, index) in job.featureText" :key="index">{{ item }}</div>
            </div>
          </div>
        </div>
        <div
          class="
            favorite-card-footer
            d-flex
            justify-content-between
            align-items-start
            flex-wrap
          "
        >
          <button
            v-if="!isAuth"
            @click="showModal"
            class="btn btn-view-favorite event-link d-flex align-items-center"
            data-bs-toggle="modal"
            data-bs-target="#favoriteModal"
            ref="btnRedirect"
          >
            <span class="ic-txt d-inline-block lh-20">詳細を見る</span>
            <img
              src="/assets/img/user/ic_arrow_right.svg"
              class="ic-arrow-right"
              alt=""
            />
          </button>
          <a
            v-else
            :href="baseUrl + '/search/' + job.id"
            class="btn btn-view-favorite event-link d-flex align-items-center"
            ref="btnRedirect"
          >
            <span class="ic-txt d-inline-block lh-20">詳細を見る</span>
            <img
              src="/assets/img/user/ic_arrow_right.svg"
              class="ic-arrow-right"
              alt=""
            />
          </a>
          <button
            v-if="!isAuth"
            @click="showModal"
            class="btn btn-add-bookmark"
            data-bs-toggle="modal"
            data-bs-target="#favoriteModal"
          >
            <img
              class="img-icon-favorite"
              :data-id="job.id"
              :src="
                job.favorite
                  ? '/assets/img/user/ic_bookmark.svg'
                  : '/assets/img/user/icon_non_bookmark.svg'
              "
            />
          </button>
          <button v-else class="btn btn-add-bookmark" @click="favorite">
            <img
              class="img-icon-favorite"
              :data-id="job.id"
              :src="
                job.favorite
                  ? '/assets/img/user/ic_bookmark.svg'
                  : '/assets/img/user/icon_non_bookmark.svg'
              "
            />
          </button>
        </div>
      </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>
<script>
import loader from "./loader.vue";
import $ from "jquery";
export default {
  props: ["data", "job"],
  components: {
    loader,
  },
  data: function () {
    return {
      csrfToken: Laravel.csrfToken,
      isAuth: Laravel.isAuth,
      baseUrl: Laravel.baseUrl,
      flagShowLoader: false,
    };
  },
  methods: {
    jobDetail(that) {
      this.$refs.btnRedirect.click();
    },
    showModal() {
      $(".btn-redirect-login").prop(
        "href",
        "/login?url_redirect=" + this.baseUrl + "/search/" + this.job.id
      );
    },
    favorite() {
      event.stopPropagation();
      let that = this;
      // this.flagShowLoader = true;
      axios
        .post("/favorite", {
          _token: Laravel.csrfToken,
          job_id: this.job.id,
        })
        .then(function (res) {
          that.flagShowLoader = false;
          $(".img-icon-favorite").each(function () {
            if ($(this).attr("data-id") == that.job.id) {
              if (that.job.favorite) {
                $(this).prop("src", "/assets/img/user/icon_non_bookmark.svg");
              } else {
                $(this).prop("src", "/assets/img/user/ic_bookmark.svg");
              }
            }
          });
          if (res.data.status == 200) {
            that.job.favorite = that.job.favorite ? "" : 1;
            if (that.data.isReload) {
              location.reload();
            }
          } else if (res.data.status == 401) {
            location.href =
              window.Laravel.baseUrl +
              "/login?url_redirect=" +
              window.location.href;
          }
        })
        .catch((error) => {});
    },
    convertNl2br(data) {
      if (data) {
        data = data.replace(/(?:\r\n|\r|\n)/g, "<br />");
      }
      return data;
    },
    getTxt(index) {
      let txt = [];
      let that = this;
      switch (index) {
        case 1:
          if (this.job.desired_costs) {
            this.job.desired_costs.forEach((element) => {
              let findItemMaster = that.data.desiredUnitPriceMasters.find(
                (x) => x.id == element.id
              );
              if (findItemMaster) {
                txt.push(findItemMaster.desired_cost_name);
              }
            });
          }
          break;
        case 2:
          if (this.job.areas) {
            this.job.areas.forEach((element) => {
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