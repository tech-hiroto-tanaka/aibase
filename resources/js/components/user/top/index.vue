<template>
  <div>
    <Splide
      :has-track="false"
      :options="options"
      aria-label="Top slider"
      class="top-slider-container"
    >
      <SplideTrack>
        <SplideSlide>
          <div class="top-banner top-banner-slider top-other-slider">
             <div class="top-banner-overlay"></div>
            <div class="bnr-img">
              <a href="/register" style="width:100%" class="d-flex justify-content-center">
              <img src="/assets/img/user/top-fv-1.png" alt="" class="d-none d-sm-block">
              <img src="/assets/img/user/sp/top-fv-sp.png" alt="" class="d-block d-sm-none">
              </a>
            </div>
          </div>
        </SplideSlide>
        <SplideSlide>
          <div class="top-banner top-banner-slider top-other-slider">
            <div class="top-banner-overlay"></div>
            <div class="bnr-img">
              <img src="/assets/img/user/top-fv-2.png" alt="" class="d-none d-sm-block">
              <img src="/assets/img/user/sp/top-fv-sp-2.png" alt="" class="d-block d-sm-none">
            </div>
          </div>
        </SplideSlide>
        <SplideSlide>
          <div class="top-banner top-banner-slider top-other-slider">
            <div class="top-banner-overlay"></div>
            <div class="bnr-img">
              <img src="/assets/img/user/top-fv-3.png" alt="" class="d-none d-sm-block">
              <img src="/assets/img/user/sp/top-fv-sp-3.png" alt="" class="d-block d-sm-none">
            </div>
          </div>
        </SplideSlide>
      </SplideTrack>
    </Splide>

    <div
      class="top-banner-footer"
      v-if="data.isAuth==false"
    >
      <div class="top-banner-button circle btn-redirect-register">
        <a href="/register" class="btn circle">
          <span class="event-link">無料でカンタン!!今すぐ会員登録!!  </span><span class="rarr">&rarr;</span>
        </a>
      </div>
    </div>

    <div style="height: 50px"></div>
    <jobSlider
      :txtConfig="{ h3: 'NEW', h2: '新着案件' }"
      :data="data"
      class="top-job-slider"
    ></jobSlider>
    <search :data="data"></search>
    <new-top :data="data"> </new-top>
    <!-- <favorite-modal></favorite-modal> -->
  </div>
</template>

<script>
import jobSlider from "../../common/jobSlider.vue";
import search from "./search.vue";
import newTop from "./newTop.vue";
import { Splide, SplideSlide, SplideTrack } from "@splidejs/vue-splide";
import "@splidejs/vue-splide/css";
// import favoriteModal from "../../common/favoriteModal.vue";
export default {
  components: {
    jobSlider,
    search,
    newTop,
    Splide,
    SplideSlide,
    SplideTrack,
    // favoriteModal,
  },
  props: ["data"],
  setup() {
    const options = {
      rewind: true,
      type: "loop",
      autoplay: true,
      interval: 3000,
      speed: 1000,
      drag: true,
      pagination: false,
      breakpoints: {
        991: {

        },
        767: {

        },
      },
    };
    return { options };
  },
};
</script>