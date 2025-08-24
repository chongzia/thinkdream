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
const api = 'shop/product/tags'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'name',
    label: '标签名称'
  },
  {
    prop: 'sort',
    label: '排序'
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
    name: 'name',
    label: '标签名称'
  }
]
</script>
