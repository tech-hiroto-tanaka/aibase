<template>
  <div class="favorite-content">
    <div class="container favorite-container">
      <h2 class="title text-center">お気に入り案件</h2>
      <div class="favorite-list-wrapper">
        <div class="favorite-list">
          <ItemFavorite
            v-for="i in 6"
            :key="i"
          ></ItemFavorite>
        </div>
        <div class="paginate">
          <a href="" class="current">1</a>
          <a href="">2</a>
          <a href="">3</a>
          <a href="">4</a>
          <a href="">5</a>
        </div>
      </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>
<script>
import ItemFavorite from "../../common/itemFavorite.vue";
export default {
  setup() {},
  created: function () {},
  data() {
    return {
      flagShowLoader: false,
      csrfToken: Laravel.csrfToken,
      baseUrl: Laravel.baseUrl,
    };
  },
  mounted() {},
  props: ["data"],
  components: {
    ItemFavorite
  },
  methods: {},
  watch: {},
};
</script>