<template>
  <div class="col-md-4 border-right search-left py-5">
    <form action="/search" method="GET" id="formCondition">
      <!-- <input type="hidden" :value="csrfToken" name="_token" /> -->
      <input type="hidden" name="sort" :value="data.request.sort" id="sortValue" />
      <input type="hidden" name="direction" :value="data.request.direction" />
      <div class="search-filters">
        <h5 class="title-line mb-4">
          <span>案件検索</span>
        </h5>

        <div class="d-flex align-items-center mb-3">
          <input
            type="text"
            name="search_input"
            v-model="request.search_input"
            class="form-control py-3 search_input"
            placeholder="キーワード検索"
          />
          <div @click="submit" class="flex-shrink-0 ml-14 text-primary">
            <i class="fa fa-search fa-2x"></i>
          </div>
        </div>

        <div class="search-filter-box pl-5 font-15">
          <div class="box-item">
            <div
              class="box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtGenre">ジャンルを選択</div>
              <i
                class="chevron-circle-down"
                style="font-size: 1.5em"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-1"
              ></i>
            </div>

            <div class="box-values mt-2 collapse" id="collapse-1">
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
          <div class="box-item">
            <div
              class="box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtArea">エリアを選択</div>
              <i
                class="chevron-circle-down"
                style="font-size: 1.5em"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-2"
              ></i>
            </div>

            <div class="box-values mt-2 collapse" id="collapse-2">
              <div
                v-for="item in data.areaMasters"
                :key="item.id"
                class="form-check mb-2 form-area"
              >
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
                <label class="form-check-label" :for="'area_' + item.id">
                  {{ item.area_name }}
                </label>
                <div
                  style="margin-top: 5px"
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
                      class="form-check mb-2"
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
          <div class="box-item">
            <div
              class="box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtSkill">スキルワードを選択</div>
              <i
                class="chevron-circle-down"
                style="font-size: 1.5em"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-3"
              ></i>
            </div>

            <div class="box-values mt-2 collapse" id="collapse-3">
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
          <div class="box-item">
            <div
              class="box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtDesiredCost">希望単価を選択</div>
              <i
                class="chevron-circle-down"
                style="font-size: 1.5em"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-4"
              ></i>
            </div>

            <div class="box-values mt-2 collapse" id="collapse-4">
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
          <div class="box-item">
            <div
              class="box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtFeature">特徴を選択</div>
              <i
                class="chevron-circle-down"
                style="font-size: 1.5em"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-5"
              ></i>
            </div>

            <div class="box-values mt-2 collapse" id="collapse-5">
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
          <div class="box-item">
            <div
              class="box-title d-flex align-items-center fw-bold cursor-pointer"
            >
              <div class="flex-grow-1 txtTypeOfJobs">契約形態を選択</div>
              <i
                class="chevron-circle-down"
                style="font-size: 1.5em"
                data-bs-toggle="collapse"
                data-bs-target="#collapse-6"
              ></i>
            </div>

            <div class="box-values mt-2 collapse" id="collapse-6">
              <div
                class="form-check mb-2"
              >
                <input
                  class="form-check-input rounded-0"
                  type="checkbox"
                  name="typeOfJobs[]"
                  @change="getTotalJob"
                  value="0"
                  id="typeOfJobs_0"
                  :checked="
                    request.typeOfJobs &&
                    request.typeOfJobs.find((x) => x == 0)
                  "
                />
                <label class="form-check-label" for="typeOfJobs_0">
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
                  id="typeOfJobs_1"
                  :checked="
                    request.typeOfJobs &&
                    request.typeOfJobs.find((x) => x == 1)
                  "
                />
                <label class="form-check-label" for="typeOfJobs_1">
                  派遣
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="box-total-item">
          <div class="text-center mb-3 fw-bold font-15 lh-20">該当案件数</div>
          <div
            class="text-center d-flex justify-content-center align-items-end"
          >
            <div class="mb-0">
              <count-up :end-val="totalJob"></count-up>
            </div>
            <span class="fw-bold font-15 lh-30">件</span>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2 ml-5">
          <button
            @click="clearCondition"
            type="button"
            class="btn rounded-0 btn-search py-2"
          >
            条件をクリア
          </button>
          <button
            type="submit"
            ref="btnSubmit"
            class="btn rounded-0 btn-search_ex py-2"
          >
            検索
          </button>
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
    $(document).on("click", ".flex-grow-1", function () {
      let eleI = $(this).closest(".box-title").find("i");
      if (!eleI.attr("data-bs-target")) {
        return;
      }
      const $collapse = $(`${eleI.attr("data-bs-target")}`);

      if ($collapse.is(":visible")) {
        eleI.css({
          transition: "0.2s",
          transform: "rotate(0deg)",
        });
        eleI.closest(".box-title").removeClass("open");
      } else {
        eleI.css({
          transition: "0.2s",
          transform: "rotate(180deg)",
        });
        eleI.closest(".box-title").addClass("open");
      }
      $collapse.slideToggle(200);
    });
    // $(document).on("click", '[data-bs-toggle="collapse"]', function () {
    //   $(this).closest('div').find('.flex-grow-1').trigger('click');
    // });
    if (this.data.request.genres) {
      $(".txtGenre").trigger("click");
    }
    if (this.data.request.areas || this.data.request.prefectures) {
      $(".txtArea").trigger("click");
    }
    if (this.data.request.skills) {
      $(".txtSkill").trigger("click");
    }
    if (this.data.request.features) {
      $(".txtFeature").trigger("click");
    }
    if (this.data.request.desiredCosts) {
      $(".txtDesiredCost").trigger("click");
    }
    if (this.data.request.typeOfJobs) {
      $(".txtTypeOfJobs").trigger("click");
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
  },
  props: ["data"],
  methods: {
    clearCondition() {
      this.request = [];
      window.location.href = window.location.origin + window.location.pathname;
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
  },
  created() {},
};
</script>

<style>
</style>