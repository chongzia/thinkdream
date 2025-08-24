<template>
  <catch-table :columns="columns" :api="api" :search-form="search" dialog-width="1200px" :operation="false">
    <template #dialog="row">
      <Create :primary="row?.id" :api="api" />
    </template>

    <!--优惠方式-->
    <template #promotion="scope">
      {{ '满 ' + scope.row.min_price + ' 元 ' + (scope.row.type === 1 ? '减 ' + scope.row.reduce_price + ' 元' : '打 ' + scope.row.discount + ' 折') }}
    </template>
    <!-- 有效期 -->
    <template #validaty="scope">
      <div v-if="scope.row.expire_type === 1">
        {{ date('YYYY-MM-DD HH:mm:ss', scope.row.created_at + scope.row.validaty * 24 * 3600) }}
      </div>
      <div v-else>
        <div><el-tag>开始时间</el-tag> {{ date('YYYY-MM-DD', scope.row.start_at) }}</div>
        <div class="mt-1"><el-tag>结束时间</el-tag> {{ date('YYYY-MM-DD', scope.row.end_at) }}</div>
      </div>
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
import { date } from '@/support/helper'
const api = 'shop/coupon/receive/records'

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
    slot: 'promotion',
    label: '优惠方式'
  },
  {
    slot: 'validaty',
    label: '有效期'
  },
  {
    prop: 'status',
    label: '状态',
    tags: ['danger'],
    filter: (value: number) => {
      return value ? '已领取' : '未领取'
    }
  },
  {
    prop: 'created_at',
    label: '领取时间'
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
    type: 'input',
    name: 'username',
    label: '会员名称'
  },
  {
    type: 'select',
    name: 'status',
    label: '领取状态',
    options: [
      {
        label: '未领取',
        value: 0
      },
      {
        label: '已领取',
        value: 1
      }
    ]
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
