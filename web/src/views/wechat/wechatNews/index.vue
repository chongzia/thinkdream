<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" dialog-width="1000px" ref="tableRef">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
      <template #multiOperate>
        <el-button size="small" @click="select">选择</el-button>
      </template>
    </catch-table>
    <Dialog v-model="visible" destroy-on-close>
      <News :ids="selectIds" />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import Create from './form/create.vue'
import News from './form/news.vue'

const api = 'wechat/official/news'
const visible = ref(false)
const tableRef = ref()
const selectIds = ref<Array<number>>()
const select = () => {
  visible.value = true
  selectIds.value = tableRef.value.getMultiSelectIds()
}
// table columns
const columns = [
  {
    type: 'selection',
    width: 50
  },
  {
    prop: 'id',
    label: 'ID',
    width: 80
  },
  {
    prop: 'title',
    label: '标题',
    ellipsis: true,
    width: 200
  },
  {
    prop: 'author',
    label: '作者'
  },
  {
    prop: 'thumb_media_id',
    label: '缩略图',
    image: true,
    align: 'center'
  },
  {
    prop: 'content_source_url',
    label: '阅读原文链接',
    link: true
  },
  {
    prop: 'digest',
    label: '描述',
    ellipsis: true
  },
  {
    prop: 'show_cover_pic',
    label: '是否展示封面',
    switch: true
  },
  {
    prop: 'need_open_comment',
    label: '是否打开评论',
    switch: true
  },
  {
    prop: 'only_fans_can_comment',
    label: '粉丝可评论',
    switch: true
  },
  {
    type: 'operate',
    label: '操作'
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'title',
    label: '标题'
  }
]
</script>
