<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
      <template #operate="scope">
        <el-button size="small" @click="test(scope.row.id)" text><Icon name="wrench-screwdriver" className="w-3 h-3 mr-1" /> 测试</el-button>
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import Create from './form/create.vue'
import http from '@/support/http'
import Message from '@/support/message'
const api = 'system/webhook'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 80
  },
  {
    prop: 'platform',
    label: '平台',
    filter: (platform: number) => {
      return platform === 1 ? '钉钉' : platform === 2 ? '飞书' : '企微'
    },
    width: 150
  },
  {
    prop: 'webhook',
    label: '推送地址'
  },
  {
    prop: 'msg_type',
    label: '消息类型',
    width: 150
  },
  {
    prop: 'status',
    label: '状态',
    switch: true,
    width: 200
  },
  {
    prop: 'created_at',
    label: '创建时间',
    width: 200
  },
  {
    type: 'operate',
    label: '操作',
    width: 200
  }
]

// table search
const search = [
  {
    type: 'select',
    name: 'platform',
    label: '平台',
    options: [
      {
        value: 1,
        label: '钉钉'
      },
      {
        value: 2,
        label: '飞书'
      },
      {
        value: 3,
        label: '企微'
      }
    ]
  },
  {
    type: 'select',
    name: 'status',
    label: '状态',
    options: [
      {
        value: 1,
        label: '开启'
      },
      {
        value: 2,
        label: '关闭'
      }
    ]
  }
]

const test = (id: number) => {
  http.get(`${api}/test/${id}`).then(r => {
    Message.success('发送成功')
  })
}
</script>
