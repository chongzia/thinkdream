<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>

      <template #_operate="row">
        <el-button text @click="knowledgeFilesDialogVisibe = true" type="warning" :icon="Files">知识库文件</el-button>
      </template>
    </catch-table>

    <Dialog v-model="knowledgeFilesDialogVisibe" title="知识库文件" width="1200px" content-top="pt-0">
      <KnowleageFiles />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import KnowleageFiles from '@/views/ai/aiKnowledgeFiles/index.vue'
import Create from './form/create.vue'
import { Files } from '@element-plus/icons-vue'
const api = 'ai/knowledge/base'
const knowledgeFilesDialogVisibe = ref(false)
// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'title',
    label: '知识库标题'
  },
  {
    prop: 'embedding_model',
    label: '向量模型'
  },
  {
    prop: 'sort',
    label: '排序',
    sortable: true
  },
  {
    prop: 'status',
    label: '状态',
    switch: true
  },
  {
    prop: 'created_at',
    label: '创建时间'
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
    label: '知识库标题'
  }
]
</script>
