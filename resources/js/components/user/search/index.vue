<template>
  <condition
    :data="data"
    class="search-condition"
    v-if="!isMobile()"
  ></condition>
  <!-- @include('search.left') -->

  <!-- @include('search.right') -->

  <!-- <div class="search-suggest pt-5">
        <div class="container">
            {{-- {!! view('top.slider', ['h2' => 'おすすめ案件']) !!} --}}
        </div>
    </div> -->
</template>

<script>
import condition from "./condition.vue";
export default {
  components: {
    condition,
  },
  props: ["data"],
  methods: {
    isMobile () {
      if(window.innerWidth < 576 || screen.width < 576) {
        return true;
      }
      return false;
    },
  }
};
</script>