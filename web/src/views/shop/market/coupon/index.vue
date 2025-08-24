<template>
  <catch-table :columns="columns" :api="api" :search-form="search" dialog-width="1200px">
    <template #dialog="row">
      <Create :primary="row?.id" :api="api" :users-count="row.users_count" />
    </template>

    <!--优惠方式-->
    <template #promotion="scope">
      {{ '满 ' + scope.row.min_price + ' 元 ' + (scope.row.type === 1 ? '减 ' + scope.row.reduce_price + ' 元' : '打 ' + scope.row.discount + ' 折') }}
    </template>
    <!-- 操作 -->
    <template #operate="scope">
      <router-link :to="`/shop/market/coupon/give/${scope.row.id}`">
        <el-button type="success" size="small" text>
          <Icon name="cursor-arrow-ripple" className="w-4 h-4 mr-1" />
          发 放
        </el-button>
      </router-link>
    </template>
  </catch-table>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'shop/coupon'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'title',
    label: '优惠券名称'
  },
  {
    prop: 'type',
    label: '优惠卷类型',
    tags: ['info', 'info'],
    filter: (value: number) => {
      return value === 1 ? '满减券' : '折扣券'
    }
  },
  {
    prop: 'min_price',
    label: '最低消费金额（元）'
  },
  {
    prop: 'total_num',
    label: '总数量'
  },
  {
    prop: 'receive_num',
    label: '领取总数量'
  },
  {
    slot: 'promotion',
    label: '优惠方式'
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
    label: '操作'
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'title',
    label: '优惠券名称'
  },
  {
    type: 'select',
    name: 'type',
    label: '优惠卷类型',
    options: [
      {
        label: '满减优惠',
        value: 1
      },
      {
        label: '折扣优惠',
        value: 2
      }
    ]
  },
  {
    type: 'select',
    name: 'expire_type',
    label: '到期类型',
    options: [
      {
        label: '领取后生效',
        value: 1
      },
      {
        label: '固定时间',
        value: 2
      }
    ]
  }
]
</script>
