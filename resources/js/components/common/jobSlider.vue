<template>
  <div class="container bg-white">
    <div class="p-md-4">
      <h3 v-if="txtConfig.h3" class="section-title text-center text-primary mb-2">
        <img
          style="margin-bottom: 4px"
          src="/assets/img/user/ic_volume.svg"
          alt=""
        />
        {{ txtConfig.h3 }}
      </h3>
      <h2 v-if="txtConfig.h2" class="section-desc text-center mb-4 recommended-projects">{{ txtConfig.h2 }}</h2>
      <template v-if="data.jobNews.length">
        <div class="row favorite-row">
          <Splide
            :has-track="false"
            :options="options"
            aria-label="Job Slider"
            class="job-slider-container"
          >
            <SplideTrack>
              <SplideSlide
                v-for="(item, index) in data.jobNews"
                :key="index"
                class="job-slider-item"
              >
                <favorite :job="item" :data="data"></favorite>
              </SplideSlide>
            </SplideTrack>
            <div class="splide__arrows">
              <button class="splide__arrow splide__arrow--prev">
                <img src="/assets/img/user/ic_arrow_left_white.svg" alt="" />
              </button>
              <button class="splide__arrow splide__arrow--next">
                <img src="/assets/img/user/ic_arrow_right_white.svg" alt="" />
              </button>
            </div>
          </Splide>
        </div>
        <div class="text-center mb-5 mt-5" v-if="!data.isDetail">
          <a href="/search" class="me-4 event-link">もっと見る</a>
          <small><i class="fa fa-chevron-right"></i></small>
        </div>
      </template>
      <dataEmpty v-else></dataEmpty>
    </div>
  </div>
</template>

<script>
import dataEmpty from "../common/dataEmpty.vue";
import favorite from "./itemFavorite.vue";
import { Splide, SplideSlide, SplideTrack } from "@splidejs/vue-splide";
import "@splidejs/vue-splide/css";

export default {
  mounted() {},
  props: ["txtConfig", "data"],
  components: {
    favorite,
    dataEmpty,
    Splide,
    SplideSlide,
    SplideTrack,
  },
  setup() {
    const options = {
      rewind: true,
      type: "loop",
      perPage: 3,
      perMove: 1,
      autoplay: true,
      interval: 3000,
      speed: 1000,
      drag: true,
      pagination: false,
      breakpoints: {
        991: {
          perPage: 2,
        },
        767: {
          perPage: 1,
          arrows: false,
          padding: '16px',
        },
      },
    };
    return { options };
  },
};
</script>

<style>
</style>