<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false" :search-form="search"> </catch-table>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

const api = 'ai/model/session'

// table columns
const columns = [
  {
    prop: 'session_id',
    label: '会话ID'
  },
  {
    prop: 'title',
    label: '会话标题'
  },
  {
    prop: 'user_id',
    label: '会话用户ID'
  },
  {
    prop: 'bot_id',
    label: '会话智能体'
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    type: 'operate',
    label: '操作',
    update: false
  }
]
// table search
const search = [
  {
    type: 'input',
    name: 'title',
    label: '会话标题'
  }
]
</script>
