<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" :operation="false" />
  </div>
</template>

<script lang="ts" setup>
const api = 'system/connector/log'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID'
  },
  {
    prop: 'username',
    label: '用户名'
  },
  {
    prop: 'path',
    label: '接口地址'
  },
  {
    prop: 'method',
    label: '请求方法'
  },
  {
    prop: 'user_agent',
    label: 'ua'
  },
  {
    prop: 'ip',
    label: 'ip地址'
  },
  {
    prop: 'controller',
    label: '控制器'
  },
  {
    prop: 'action',
    label: '方法'
  },
  {
    prop: 'time_taken',
    label: '耗时(ms)'
  },
  {
    prop: 'status_code',
    label: '状态码'
  },
  {
    prop: 'created_at',
    label: '创建时间'
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'username',
    label: '用户名'
  }
]
</script>
