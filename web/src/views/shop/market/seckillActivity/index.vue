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
const api = 'shop/seckill/activity'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'product_title',
    label: '秒杀商品'
  },
  {
    prop: 'activity_start_date',
    label: '活动开始日期'
  },
  {
    prop: 'activity_end_date',
    label: '活动结束日期'
  },
  {
    prop: 'status',
    label: '活动状态',
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
    name: 'title',
    label: '秒杀商品名称'
  }
]
</script>
