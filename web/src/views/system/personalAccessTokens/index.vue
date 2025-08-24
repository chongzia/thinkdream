<template>
  <catch-table :columns="columns" :api="api" :operation="false" />
</template>

<script lang="ts" setup>
const api = 'system/personal/access/tokens'

// table columns
const columns = [
  {
    type: 'selection'
  },
  {
    prop: 'id',
    label: 'ID',
    width: 80
  },
  {
    prop: 'tokenable_type',
    label: 'token模型',
    width: 230
  },
  {
    prop: 'username',
    label: '所属者'
  },
  {
    prop: 'location',
    label: '归属地'
  },
  {
    prop: 'last_used_at',
    label: '最近使用时间'
  },
  {
    prop: 'expires_at',
    label: '过期时间'
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
</script>
