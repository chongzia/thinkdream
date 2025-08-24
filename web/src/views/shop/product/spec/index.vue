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
import { ref } from 'vue'
import Create from './form/create.vue'
const api = 'shop/product/spec'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID'
  },
  {
    prop: 'name',
    label: '规格名称'
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
    label: '规格名称'
  }
]
</script>
