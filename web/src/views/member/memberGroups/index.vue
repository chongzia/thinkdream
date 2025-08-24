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
import Create from './form/create.vue'
const api = 'member/member/groups'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'name',
    label: '组名'
  },
  {
    prop: 'description',
    label: '分组描述'
  },
  {
    prop: 'status',
    label: '状态'
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
    label: '操作'
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'name',
    label: '组名'
  },
  {
    type: 'radio',
    name: 'status',
    label: '状态'
  }
]
</script>
