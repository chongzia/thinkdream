<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" :operation="false"> </catch-table>
  </div>
</template>

<script lang="ts" setup>
const api = 'openapi/openapi/request/log'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'request_id',
    label: '请求ID'
  },
  {
    prop: 'app_key',
    label: 'app key'
  },
  {
    prop: 'data',
    label: '请求数据'
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    prop: 'updated_at',
    label: '更新时间'
  },
  {
    type: 'operate',
    update: false,
    label: '操作',
    width: 200
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'app_key',
    label: 'AppKey'
  },
  {
    type: 'input',
    name: 'request_id',
    label: '请求ID'
  }
]
</script>
