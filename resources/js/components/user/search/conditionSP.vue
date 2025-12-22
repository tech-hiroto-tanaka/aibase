<template>
  <div class="search-modal-content position-relative">
    <form action="/search" method="GET" id="formCondition">
      <input type="hidden" name="sort" :value="data.request.sort" id="sortValue" />
      <input type="hidden" name="direction" :value="data.request.direction" />
      <div class="search-filters">
        <div class="search-filter-header">
          <div class="d-flex align-items-center search-input-container">
            <input
              type="text"
              name="search_input"
              v-model="request.search_input"
              class="form-control py-3 search_input"
              placeholder="キーワード検索"
            />
            <div @click="submit" class="flex-shrink-0 text-primary ic-search">
              <i class="fa fa-search"></i>
            </div>
          </div>
          <div class="search-item-header">
            <a class="s-link" href="#s-genre">
              ジャンル
              <span>▼</span>
            </a>
            <a class="s-link" href="#s-area">
              エリア
              <span>▼</span>
            </a>
            <a class="s-link" href="#s-skill">
              スキル
              <span>▼</span>
            </a>
            <a class="s-link" href="#s-desired-cost">
              単価
              <span>▼</span>
            </a>
            <a class="s-link" href="#s-feature-content">
              特徴
              <span>▼</span>
            </a>
            <a class="s-link" href="#s-type-job">
              契約形態
              <span>▼</span>
            </a>
          </div>
        </div>
        <div class="search-filter-box font-15">
          <div class="box-item" id="s-genre">
            <div
              class="box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="box-item-title flex-grow-1 txtGenre">ジャンルを選択</div>
            </div>

            <div class="box-values" id="collapse-1">
              <div
                v-for="item in data.genreMasters"
                :key="item.id"
                class="form-check mb-2"
              >
                <input
                  class="form-check-input rounded-0"
                  type="checkbox"
                  @change="getTotalJob"
                  name="genres[]"
                  :value="item.id"
                  :id="'genre_' + item.id"
                  :checked="
                    request.genres && request.genres.find((x) => x == item.id)
                  "
                />
                <label class="form-check-label" :for="'genre_' + item.id">
                  {{ item.genre_name }}
                </label>
              </div>
            </div>
          </div>
          <div class="box-item" id="s-area">
            <div
              class="box-item-title box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtArea">エリアを選択</div>
            </div>
            <div class="box-area" id="collapse-2">
              <div
                v-for="item in data.areaMasters"
                :key="item.id"
                class="form-check form-area"
              >
                <div class="box-area-value">
                  <input
                    class="form-check-input rounded-0 input-area"
                    type="checkbox"
                    name="areas[]"
                    @change="getTotalJob"
                    :value="item.id"
                    :id="'area_' + item.id"
                    :checked="
                    request.areas && request.areas.find((x) => x == item.id)
                  "
                  />
                  <label class="form-check-label w-auto d-inline-block" :for="'area_' + item.id">
                    {{ item.area_name }}
                  </label>
                  <a
                    :href="'#box-' + item.id"
                    data-bs-toggle="collapse"
                    class="ic-arrow-down"
                  >
                    <img src="/assets/img/user/sp/ic_arrow_down.svg" alt="">
                  </a>
                </div>
                <div
                  class="box-area-child collapse"
                  :id="'box-' + item.id"
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
                      v-if="pref.prefecture"
                      class="form-check"
                    >
                      <input
                        class="form-check-input rounded-0 input-pref"
                        type="checkbox"
                        name="prefectures[]"
                        @change="getTotalJob"
                        :value="pref.prefecture.id"
                        :id="'prefecture_' + pref.prefecture.id"
                        :area-id="pref.area_id"
                        :checked="
                          request.prefectures &&
                          request.prefectures.find((x) => x == pref.prefecture.id)
                        "
                      />
                      <label
                        class="form-check-label"
                        :for="'prefecture_' + pref.prefecture.id"
                      >
                        {{ pref.prefecture.prefecture_name }}
                      </label>
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>
          <div class="box-item" id="s-skill">
            <div
              class="box-item-title box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtSkill">スキルワードを選択</div>
            </div>

            <div class="box-values" id="collapse-3">
              <div
                v-for="item in data.skillWordMasters"
                :key="item.id"
                class="form-check mb-2"
              >
                <input
                  class="form-check-input rounded-0"
                  type="checkbox"
                  name="skills[]"
                  @change="getTotalJob"
                  :value="item.id"
                  :id="'skill_' + item.id"
                  :checked="
                    request.skills && request.skills.find((x) => x == item.id)
                  "
                />
                <label class="form-check-label" :for="'skill_' + item.id">
                  {{ item.skill_name }}
                </label>
              </div>
            </div>
          </div>
          <div class="box-item" id="s-desired-cost">
            <div
              class="box-item-title box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtDesiredCost">希望単価を選択</div>
            </div>

            <div class="box-values" id="collapse-4">
              <div
                v-for="item in data.desiredUnitPriceMasters"
                :key="item.id"
                class="form-check mb-2"
              >
                <input
                  class="form-check-input input-desired rounded-0"
                  type="checkbox"
                  name="desiredCosts[]"
                  @change="getTotalJob"
                  :value="item.id"
                  :data-money="item.money"
                  :id="'desired_cost_' + item.id"
                  :checked="
                    request.desiredCosts &&
                    request.desiredCosts.find((x) => x == item.id)
                  "
                />
                <label
                  class="form-check-label"
                  :for="'desired_cost_' + item.id"
                >
                  {{ item.desired_cost_name }}
                </label>
              </div>
            </div>
          </div>
          <div class="box-item" id="s-feature-content">
            <div
              class="box-item-title box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtFeature">特徴を選択</div>
            </div>

            <div class="box-values" id="collapse-5">
              <div
                v-for="item in data.featureMasters"
                :key="item.id"
                class="form-check mb-2"
              >
                <input
                  class="form-check-input rounded-0"
                  type="checkbox"
                  name="features[]"
                  @change="getTotalJob"
                  :value="item.id"
                  :id="'feature_' + item.id"
                  :checked="
                    request.features &&
                    request.features.find((x) => x == item.id)
                  "
                />
                <label class="form-check-label" :for="'feature_' + item.id">
                  {{ item.feature_name }}
                </label>
              </div>
            </div>
          </div>
          <div class="box-item box-item-type-job" id="s-type-job">
            <div
              class="box-item-title box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtTypeOfJobs">契約形態を選択</div>
            </div>
            <div class="box-values" id="collapse-6">
              <div
                class="form-check"
              >
                <input
                  class="form-check-input rounded-0"
                  type="checkbox"
                  name="typeOfJobs[]"
                  @change="getTotalJob"
                  value="0"
                  id="s_feature_0"
                  :checked="
                    request.typeOfJobs &&
                    request.typeOfJobs.find((x) => x == 0)
                  "
                />
                <label class="form-check-label" for="s_feature_0">
                  共同受注
                </label>
              </div>
              <div
                class="form-check mb-2"
              >
                <input
                  class="form-check-input rounded-0"
                  type="checkbox"
                  name="typeOfJobs[]"
                  @change="getTotalJob"
                  value="1"
                  id="s_feature_1"
                  :checked="
                    request.typeOfJobs &&
                    request.typeOfJobs.find((x) => x == 1)
                  "
                />
                <label class="form-check-label" for="s_feature_1">
                  派遣
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="search-filter-footer">
          <div class="d-flex justify-content-between align-item-center w-100">
            <div class="total-result">
              <div class="total-result-container">
                <p class="txt-total">該当案件数</p>
                <div
                  class="text-center d-flex justify-content-center align-items-baseline total-job-txt"
                >
                  <count-up :end-val="totalJob"></count-up>件
                </div>
              </div>
            </div>
            <div class="search-modal-btn d-flex justify-content-end align-items-center">
              <button
                @click="clearCondition"
                type="button"
                class="btn btn-clear-condition"
              >
                条件をクリア
              </button>
              <button
                type="submit"
                ref="btnSubmit"
                class="btn btn-modal-search"
              >
                <img src="/assets/img/user/sp/ic_search.svg" alt="">
                検索
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import CountUp from "vue-countup-v3";
export default {
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
      request: this.data.request,
      totalJob: this.data.totalJob,
    };
  },
  components: {
    CountUp,
  },
  mounted() {
    $(document).on("change", "select#search_order", function () {
      $("#sortValue").val($(this).val());
      $('[name="direction"]').val('desc');
      if ($(this).val() == 'min_desired_costs') {
        // $('[name="direction"]').val('asc');
      }
      setTimeout(function () {
        $("#formCondition").submit();
      }, 500);
    });
    if (this.data.request.prefectures) {
      this.data.request.prefectures.forEach((val) => {
        let boxHeader = $('input[id = "prefecture_' + val +'"]').attr('area-id');
        $('#box-' + boxHeader).addClass('show');
      });
    }
    $(document).on("click", ".input-desired", function () {
      let money = parseInt($(this).attr('data-money'));
      if ($(this).is(":checked")) {
        $(".input-desired").each(function () {
          if (money <= parseInt($(this).attr('data-money'))) {
            $(this).prop("checked", true);
          }
        })
      }
    })
    $(document).on("click", ".input-area", function () {
      let isChecked = $(this).is(":checked");
      let areaId = $(this).attr("value");
      $(".input-pref").each(function () {
        if ($(this).attr("area-id") == areaId) {
          if (isChecked) {
            $(this).prop("checked", true);
          } else {
            $(this).prop("checked", false);
          }
        }
      });
    });
    let that = this;
    $(document).on('click', '.input-pref', function() {
      let areaId = $(this).attr("area-id");
      let countChecked = 0;
      let infoArea = that.data.areaMasters.find(x => x.id == areaId);
      $(".input-pref").each(function () {
        if ($(this).attr("area-id") == areaId) {
          if ($(this).is(':checked')) {
            countChecked++;
          }
        }
      });
      if (infoArea.area_prefectures.length == countChecked) {
        $(this).closest('.form-area').find('.input-area').prop('checked', true);
      } else {
        $(this).closest('.form-area').find('.input-area').prop('checked', false);
      }
    })
    $(function() {
      $(".input-area").each(function () {
        let isChecked = $(this).is(":checked");
        let areaId = $(this).attr("value");
        $(".input-pref").each(function () {
          if ($(this).attr("area-id") == areaId) {
            if (isChecked) {
              $(this).prop("checked", true);
            }
          }
        });
      });
    })
    this.searchScroll();
  },
  props: ["data"],
  methods: {
    clearCondition() {
      this.request = [];
      $('.form-check-input').prop('checked', false);
      this.getTotalJob();
      // window.location.href = window.location.origin + window.location.pathname;
    },
    submit() {
      this.$refs.btnSubmit.click();
    },
    getTotalJob() {
      let that = this;
      // that.flagShowLoader = true;
      axios
        .post(that.data.urlSearch, $("#formCondition").serialize())
        .then((res) => {
          that.flagShowLoader = false;
          that.totalJob = 0;
          if (res.data.status == 200) {
            that.totalJob = res.data.total;
          }
        })
        .catch((error) => {});
    },
    searchScroll() {
      let tabContainerHeight = 105;
      $('.s-link').click(function (event) {
        event.preventDefault();
        let that = $(this);
        let scrollTop = $(that.attr('href')).position().top - tabContainerHeight;
        $('#searchModalContent').animate({
          scrollTop: scrollTop
        }, 300);
      });
    }
  },
  created() {},
};
</script>

<style>
</style>