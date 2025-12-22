<template>
  <div class="container bg-white">
    <div class="news-section-wrapper">
      <h3 class="section-title text-center text-primary">NEWS</h3>
      <h2 class="section-desc text-center">お知らせ</h2>
      <div class="row justify-content-center" v-if="data.topNews.length">
        <div class="col-md-8">
          <div class="top-news-list">
            <div v-for="item in data.topNews" :key="item.id" :class="data.isAuth && !item.user_new ? 'news-item unread item' : 'news-item item'">
              <a :href="'/news/' + item.id" class="news-publish-date">{{item.publish_start_date_format_1}}</a>
              <span class="badge bg-warning text-black px-3 news-category" style="border-radius: 30px">お知らせ</span>
              <a class="break-all news-item-title" :href="'/news/' + item.id">{{ item.news_title }}</a>
            </div>
          </div>
          <div class="text-center">
            <a href="/news" class="me-4 link-news event-link">もっと見る</a>
            <small><i class="fa fa-chevron-right"></i></small>
          </div>
        </div>
      </div>
      <dataEmpty v-else></dataEmpty>
    </div>
  </div>
</template>

<script>
import dataEmpty from '../../common/dataEmpty.vue';
export default {
  props: ['data'],
  components: {
    dataEmpty
  }
};
</script>