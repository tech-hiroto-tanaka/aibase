<template>
  <div class="modal fade search-modal" id="searchModal" v-if="isMobile()">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 pb-0">
          <h4 class="modal-title text-center flex-grow-1">案件検索</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body search-modal-body p-0" id="searchModalContent">
          <condition-search :data="data"></condition-search>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import conditionSearch from "../user/search/conditionSP.vue";
export default {
  created() {},
  components: {
    conditionSearch,
  },
  props: ["data"],
  methods: {
    isMobile () {
      if(window.innerWidth < 576 || screen.width < 576) {
        return true;
      }
      return false;
    }
  }
};
</script>