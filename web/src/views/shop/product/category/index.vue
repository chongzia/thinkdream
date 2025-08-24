<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" row-key="id" :paginate="false">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'shop/category'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'name',
    label: '分类名称'
  },
  {
    prop: 'icon',
    label: '分类图标',
    width: 250,
    image: true
  },
  {
    prop: 'sort',
    label: '排序'
  },
  {
    prop: 'status',
    label: '状态',
    switch: true
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
    label: '分类名称'
  }
]
</script>
