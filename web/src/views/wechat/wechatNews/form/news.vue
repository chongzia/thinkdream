<template>
  <div class="w-full sm:w-2/3 mx-auto">
    <h1 class="text-xl">图文消息</h1>
    <div v-for="(article, index) in articles" :key="index" class="pb-1 border-b border-dashed border-gray-500 mt-5">
      <div class="flex relative" v-if="!index">
        <div><img :src="article.thumb_media_id" class="w-full" /></div>
        <div class="absolute bottom-0 text-white bg-neutral-600 bg-opacity-[0.6] w-full h-10 leading-10 pl-2">{{ article.title }}</div>
      </div>

      <div class="flex justify-between h-16 pt-1" v-else>
        <div class="h-full pt-5">{{ article.title }}</div>
        <div><img :src="article.thumb_media_id" class="h-full" /></div>
      </div>
    </div>

    <div class="w-full flex justify-end mt-5">
      <el-button type="primary">发布</el-button>
    </div>
  </div>
</template>
<script lang="ts" setup>
import http from '@/support/http'
import { onMounted, ref } from 'vue'

const props = defineProps({
  ids: {
    require: true,
    type: Array<number>,
    defualt: []
  }
})

interface Article {
  thumb_media_id: string
  author: string
  title: string
  content_source_url: string
  content: string
  digest: string
  show_cover_pic: number
  need_open_comment: number
  only_fans_can_comment: number
}

const articles = ref<Array<Article>>()
const getArticles = () => {
  http.get('wechat/official/news/' + props.ids?.join(',')).then(r => {
    if (Array.isArray(r.data.data)) {
      articles.value = r.data.data
    } else {
      articles.value = [r.data.data]
    }
  })
}

onMounted(() => {
  getArticles()
})
</script>
