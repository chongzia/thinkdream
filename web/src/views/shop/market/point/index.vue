<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" :operation="false"> </catch-table>
  </div>
</template>

<script lang="ts" setup>
const api = 'shop/point'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'username',
    label: '会员名称'
  },
  {
    prop: 'point_num',
    label: '变动数量'
  },
  {
    prop: 'describe',
    label: '描述'
  },
  {
    prop: 'remark',
    label: '管理员备注'
  },
  {
    slot: 'created_at',
    label: '创建时间'
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'username',
    label: '会员名称'
  },
  {
    type: 'date',
    name: 'created_at',
    label: '开始时间'
  },
  {
    type: 'date',
    name: 'end_at',
    label: '结束时间'
  }
]
</script>
