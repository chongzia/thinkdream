<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" :operation="false">
      <template #operation>
        <router-link to="/shop/market/seckill/create/product">
          <Add />
        </router-link>
      </template>
      <template #_operate="scope">
        <router-link :to="`/shop/market/seckill/create/product/${scope.row.id}`">
          <Update />
        </router-link>
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
const api = 'shop/seckill/products'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'product_title',
    label: '商品名称'
  },
  {
    prop: 'seckill_price',
    label: '秒杀价格(元)'
  },
  {
    prop: 'stock',
    label: '库存'
  },
  {
    prop: 'limit_per_user',
    label: '限购数量'
  },
  {
    prop: 'status',
    label: '状态',
    switch: true
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
    label: '操作',
    update: false
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'title',
    label: '商品名称'
  }
]
</script>
