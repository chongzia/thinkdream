<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import { date } from '@/support/helper'
import Create from './form/create.vue'
const api = 'member/members'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'username',
    label: '用户名'
  },
  {
    prop: 'email',
    label: '邮箱'
  },
  {
    prop: 'mobile',
    label: '手机号'
  },
  {
    prop: 'avatar',
    label: '头像地址',
    image: true
  },
  {
    prop: 'from',
    label: '注册来源'
  },
  {
    prop: 'status',
    label: '状态',
    switch: true
  },
  {
    prop: 'last_login_at',
    label: '最近登录时间',
    filter: (value: number) => {
      return value ? date('YYYY-MM-DD HH:mm:ss', value) : '未登录'
    }
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
    name: 'email',
    label: '邮箱'
  },
  {
    type: 'input',
    name: 'mobile',
    label: '手机号'
  },
  {
    type: 'input',
    name: 'username',
    label: '用户名'
  }
]
</script>
