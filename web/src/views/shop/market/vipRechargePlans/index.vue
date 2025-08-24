<template>
  <div>
    <catch-table :columns="columns" :api="api">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'shop/vip/recharge/plans'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'title',
    label: '套餐名称'
  },
  {
    prop: 'price',
    label: '充值金额(元)'
  },
  {
    prop: 'handsel_price',
    label: '赠送金额(元)'
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
    prop: 'updated_at',
    label: '更新时间'
  },
  {
    type: 'operate',
    label: '操作'
  }
]

// table search
</script>
