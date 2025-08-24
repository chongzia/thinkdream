<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false" :search-form="search"> </catch-table>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

const api = 'ai/model/session/messages'

// table columns
const columns = [
  {
    prop: 'session_title',
    label: '会话标题'
  },
  {
    prop: 'sender',
    label: '发送人'
  },
  {
    prop: 'type',
    label: '消息类型'
  },
  {
    prop: 'content',
    label: '消息内容'
  },
  {
    prop: 'cost_token',
    label: '消耗token'
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
  },
  {
    type: 'input',
    name: 'sender',
    label: '发送人'
  },
  {
    type: 'select',
    name: 'type',
    label: '消息类型',
    options: [
      { label: '文本', value: 1 },
      { label: '图片', value: 2 },
      { label: '音频', value: 3 },
      { label: '视频', value: 4 }
    ]
  }
]
</script>
