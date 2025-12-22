<template>
  <div class="search-section">
    <div class="container search-container">
      <div class="section-search-wrapper">
        <h3 class="section-title text-center text-primary title-search">SEARCH</h3>
        <h2 class="section-desc title-line text-center">
          <div>案件を検索する</div>
          <span class="search-title-txt">案件を検索する</span>
        </h2>
        <form action="/search" id="formSearch" method="GET">
          <!-- <input type="hidden" :value="csrfToken" name="_token" /> -->
          <div class="row">
            <div class="col-md-4 select-item">
              <select name="genres[]" @change="submit" class="form-select py-2 search-option">
                <option value="">ジャンル</option>
                <option
                  v-for="item in data.genreMasters"
                  :key="item.id"
                  :value="item.id"
                >
                  {{ item.genre_name }}
                </option>
              </select>
              <img src="/assets/img/user/kakeru.svg" alt="">
            </div>
            <div class="col-md-4 select-item">
              <select name="skills[]" @change="submit" class="form-select py-2">
                <option value="">スキルワード</option>
                <option
                  v-for="item in data.skillWordMasters"
                  :key="item.id"
                  :value="item.id"
                >
                  {{ item.skill_name }}
                </option>
              </select>
              <img src="/assets/img/user/kakeru.svg" alt="">
            </div>
            <div class="col-md-4">
              <select name="areas[]" @change="submit" class="form-select py-2">
                <option value="">エリア（都道府県）</option>
                <option
                  v-for="item in data.areaMasters"
                  :key="item.id"
                  :value="item.id"
                >
                  {{ item.area_name }}
                </option>
              </select>
            </div>
          </div>
          <div class="top-banner-button text-center">
            <button class="btn bg-primary text-white btn-top-search">
              <span>この条件で検索する</span>
              <span class="rarr ic-arrow-right">
                <img src="/assets/img/user/ic_arr_right.svg" alt="">
              </span>
            </button>
            <div class="total-job-search">
              該当件数：<count-up :end-val="totalJob"></count-up>件
            </div>
          </div>
        </form>
        <h2 class="search-detail-desc text-center fw-bold">詳細条件検索</h2>
        <div class="search-detail search-detail-header bg-white">
          <div class="search-detail-col" @click="showOption(1)">
            <div
              class="th text-center py-3 border-right"
              :class="{ selected: currentTab == 1 }"
            >
              <div class="th-text border-right py-1 px-3">ジャンルで探す</div>
            </div>
            <div class="option-mb" v-if="currentTab == 1">
              <div
                class="td p-2 ms-4 cursor-pointer"
                v-for="item in optionMaster"
                :key="item.id"
              >
                <a @click="postSearch(item)">
                  <small><i class="fa fa-chevron-right me-2"></i></small>
                  <span>{{ showTxt(item) }}</span>
                </a>
              </div>
            </div>
          </div>

          <div class="search-detail-col" @click="showOption(2)">
            <div
              class="th text-center py-3 border-right"
              :class="{ selected: currentTab == 2 }"
            >
              <div class="th-text border-right py-1 px-3">エリアで探す</div>
            </div>
            <div class="option-mb" v-if="currentTab == 2">
              <div
                class="td p-2 ms-4 cursor-pointer"
                v-for="item in optionMaster"
                :key="item.id"
              >
                <a @click="postSearch(item)">
                  <small><i class="fa fa-chevron-right me-2"></i></small>
                  <span>{{ showTxt(item) }}</span>
                </a>
                <div
                  class="search-detail"
                  v-if="
                    item.area_prefectures.length &&
                    item.area_prefectures.find((x) => x.prefecture != null)
                  "
                >
                  <template
                    v-for="pref in item.area_prefectures"
                    :key="pref.id"
                  >
                    <div
                      class="td p-2 ms-4 cursor-pointer"
                      v-if="pref.prefecture"
                    >
                      <a @click="postSearch(pref.prefecture, true)">
                        <small><i class="fa fa-chevron-right me-2"></i></small>
                        <span>{{ showTxt(pref.prefecture, true) }}</span>
                      </a>
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>

          <div class="search-detail-col" @click="showOption(3)">
            <div
              class="th text-center py-3 border-right"
              :class="{ selected: currentTab == 3 }"
            >
              <div class="th-text border-right py-1 px-3">
                スキルワードで探す
              </div>
            </div>
            <div class="option-mb" v-if="currentTab == 3">
              <div
                class="td p-2 ms-4 cursor-pointer"
                v-for="item in optionMaster"
                :key="item.id"
              >
                <a @click="postSearch(item)">
                  <small><i class="fa fa-chevron-right me-2"></i></small>
                  <span>{{ showTxt(item) }}</span>
                </a>
              </div>
            </div>
          </div>

          <div class="search-detail-col" @click="showOption(4)">
            <div
              class="th text-center py-3 border-right"
              :class="{ selected: currentTab == 4 }"
            >
              <div class="th-text border-right py-1 px-3">希望単価で探す</div>
            </div>
            <div class="option-mb" v-if="currentTab == 4">
              <div
                class="td p-2 ms-4 cursor-pointer"
                v-for="item in optionMaster"
                :key="item.id"
              >
                <a @click="postSearch(item)">
                  <small><i class="fa fa-chevron-right me-2"></i></small>
                  <span>{{ showTxt(item) }}</span>
                </a>
              </div>
            </div>
          </div>

          <div class="search-detail-col" @click="showOption(5)">
            <div
              class="th text-center py-3 border-right"
              :class="{ selected: currentTab == 5 }"
            >
              <div class="th-text border-right py-1 px-3 no-border">
                特徴で探す
              </div>
            </div>
            <div class="option-mb" v-if="currentTab == 5">
              <div
                class="td p-2 ms-4 cursor-pointer"
                v-for="item in optionMaster"
                :key="item.id"
              >
                <a @click="postSearch(item)">
                  <small><i class="fa fa-chevron-right me-2"></i></small>
                  <span>{{ showTxt(item) }}</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div
          :class="
            'search-detail search-addition bg-white' +
            (currentTab == 2 ? ' search-detail-area' : '')
          "
        >
          <div class="option-pc">
            <div
              class="td p-2 ms-4 cursor-pointer"
              v-for="item in optionMaster"
              :key="item.id"
            >
              <template v-if="currentTab != 2">
                <a @click="postSearch(item)">
                  <small><i class="fa fa-chevron-right me-2"></i></small>
                  <span>{{ showTxt(item) }}</span>
                </a>
              </template>
              <template v-else>
                <a @click="postSearch(item)" :class="item.area_prefectures.length &&
                    item.area_prefectures.find((x) => x.prefecture != null) ? 'search-detail-title' : ''">
                  <small><i class="fa fa-chevron-right me-2"></i></small>
                  <span>{{ showTxt(item) }}</span>
                </a>
                <div
                  class="search-detail"
                  v-if="
                    item.area_prefectures.length &&
                    item.area_prefectures.find((x) => x.prefecture != null)
                  "
                >
                  <div class="option-pc">
                    <template
                      v-for="pref in item.area_prefectures"
                      :key="pref.id"
                    >
                      <div
                        class="td p-2 ms-4 cursor-pointer"
                        v-if="pref.prefecture"
                      >
                        <a @click="postSearch(pref.prefecture, true)">
                          <small
                            ><i class="fa fa-chevron-right me-2"></i
                          ></small>
                          <span>{{ showTxt(pref.prefecture, true) }}</span>
                        </a>
                      </div>
                    </template>
                  </div>
                </div>
              </template>
            </div>
          </div>
          <form action="/search" id="formSearchHidden" method="GET">
            <!-- <input type="hidden" :value="csrfToken" name="_token" /> -->

            <input
              type="hidden"
              v-if="genres.length"
              :value="genres"
              name="genres[]"
            />
            <input
              type="hidden"
              v-if="areas.length"
              :value="areas"
              name="areas[]"
            />
            <input
              type="hidden"
              v-if="prefectures.length"
              :value="prefectures"
              name="prefectures[]"
            />
            <input
              type="hidden"
              v-if="skills.length"
              :value="skills"
              name="skills[]"
            />
            <input
              type="hidden"
              v-if="desiredCosts.length"
              :value="desiredCosts"
              name="desiredCosts[]"
            />
            <input
              type="hidden"
              v-if="features.length"
              :value="features"
              name="features[]"
            />
          </form>
        </div>
      </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<script>
import Loader from "../../common/loader.vue";
import CountUp from "vue-countup-v3";
export default {
  props: ["data"],
  components: {
    Loader,
    CountUp,
  },
  data() {
    return {
      flagShowLoader: false,
      optionMaster: [],
      currentTab: 1,
      totalJob: 0,
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
      genres: [],
      areas: [],
      skills: [],
      desiredCosts: [],
      features: [],
      prefectures: [],
    };
  },
  mounted() {
    this.showOption(1);
    this.submit(false);
  },
  methods: {
    submit(isLoader = true) {
      let that = this;
      if (isLoader) {
        that.flagShowLoader = true;
      }
      axios
        .post(that.data.urlSearch, $("#formSearch").serialize())
        .then((res) => {
          that.flagShowLoader = false;
          that.totalJob = 0;
          if (res.data.status == 200) {
            that.totalJob = res.data.total;
          }
        })
        .catch((error) => {});
    },
    postSearch(item, isPre = false) {
      switch (this.currentTab) {
        case 1:
          this.genres.push(item.id);
          break;
        case 2:
          if (isPre) {
            this.prefectures.push(item.id);
          } else {
            this.areas.push(item.id);
          }
          break;
        case 3:
          this.skills.push(item.id);
          break;
        case 4:
          this.desiredCosts.push(item.id);
          break;
        case 5:
          this.features.push(item.id);
          break;
      }
      setTimeout(function () {
        $("#formSearchHidden").submit();
      }, 500);
    },
    showOption(index) {
      this.currentTab = index;
      switch (index) {
        case 1:
          this.optionMaster = this.data.genreMasters;
          break;
        case 2:
          this.optionMaster = this.data.areaMasters;
          break;
        case 3:
          this.optionMaster = this.data.skillWordMasters;
          break;
        case 4:
          this.optionMaster = this.data.desiredUnitPriceMasters;
          break;
        case 5:
          this.optionMaster = this.data.featureMasters;
          break;
      }
    },
    showTxt(item, isPre) {
      switch (this.currentTab) {
        case 1:
          return item.genre_name;
          break;
        case 2:
          if (isPre) {
            return item.prefecture_name;
          }
          return item.area_name;
          break;
        case 3:
          return item.skill_name;
          break;
        case 4:
          return item.desired_cost_name;
          break;
        case 5:
          return item.feature_name;
          break;
      }
    },
  },
};
</script>

<style>
</style>