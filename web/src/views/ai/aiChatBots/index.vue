<template>
  <div>
    <catch-table :columns="columns" :api="api">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
      <template #model="scope">
        <el-tag v-for="model in scope.row.models" :key="model" size="small" class="mr-1">{{ model.name }}</el-tag>
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'ai/chat/bots'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'id',
    width: 80
  },
  {
    prop: 'title',
    label: '名称'
  },
  {
    prop: 'logo',
    label: 'logo',
    image: true,
    width: 100
  },
  {
    prop: 'models',
    label: '模型',
    slot: 'model'
  },
  {
    prop: 'prompt',
    label: '系统提示词'
  },
  {
    prop: 'is_use_knowledge',
    label: '使用知识库',
    filter: (value: any) => {
      return value ? '是' : '否'
    }
  },
  {
    prop: 'max_tokens',
    label: '最大token数'
  },
  {
    prop: 'contexts',
    label: '上下文数'
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
</script>
