<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" dialog-width="1100">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'shop/ship/template'

// table columns
const columns = [
  {
    type: 'selection'
  },
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'title',
    label: '模版名称'
  },
  {
    prop: 'bill_type',
    label: '计费方式',
    filter: (row: number) => {
      return row === 1 ? '按件计费' : row === 2 ? '按重量计费' : '按体积计费'
    }
  },
  {
    prop: 'sort',
    label: '排序',
    sortable: true
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
    name: 'title',
    label: '模版名称'
  }
]
</script>
