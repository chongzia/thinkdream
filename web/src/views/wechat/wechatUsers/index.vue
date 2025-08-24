<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false" />
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

const api = 'wechat/official/users'

// table columns
const columns = [
  {
    prop: 'nickname',
    label: '用户名'
  },
  {
    prop: 'avatar',
    label: '用户头像'
  },
  {
    prop: 'openid',
    label: 'openid'
  },
  {
    prop: 'language',
    label: '语言'
  },
  {
    prop: 'country',
    label: '国家'
  },
  {
    prop: 'province',
    label: '省份'
  },
  {
    prop: 'city',
    label: '城市'
  },
  {
    prop: 'subscribe',
    label: '订阅状态'
  },
  {
    prop: 'subscribe_time',
    label: '订阅时间'
  },
  {
    prop: 'sex',
    label: '性别'
  },
  {
    type: 'operate',
    label: '操作'
  }
]
</script>
