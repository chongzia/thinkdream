<template>
  <div>
    <catch-table
      :columns="[
        {
          label: '控制器',
          prop: 'controller'
        },
        {
          label: '方法',
          prop: 'action'
        },
        {
          label: '路由',
          prop: 'uri'
        },
        {
          label: '请求方法',
          prop: 'method',
          slot: 'method'
        },
        {
          label: '中间件',
          prop: 'middlewares',
          slot: 'middleware',
          width: 350
        }
      ]"
      :operation="false"
      :api="api"
      :search-form="[
        {
          type: 'input',
          label: '控制器',
          name: 'controller'
        },
        {
          type: 'input',
          label: '路由',
          name: 'uri'
        },
        {
          type: 'select',
          label: '请求方法',
          name: 'method',
          options: methods
        }
      ]"
      row-key="id"
      ref="catchtable"
    >
      <template #method="scope">
        <el-tag v-for="(m, k) in scope.row.method" :key="k" class="ml-1" :type="methodsType[m]">{{ m }}</el-tag>
      </template>
      <template #middleware="scope">
        <el-tag v-for="(m, k) in scope.row.middleware" :key="k" class="mt-1">{{ m }}</el-tag>
      </template>
      <template #operation>
        <el-button type="primary" @click="routeCache">缓存路由</el-button>
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import http from '@/support/http'
import Message from '@/support/message'
const api = 'system/route'
const routeCache = () => {
  http.put(api + '/cache').then(r => {
    Message.success('路由缓存成功')
  })
}

const methodsType: { [key: string]: string } = {
  get: 'primary',
  post: 'success',
  put: 'warning',
  patch: 'primary',
  delete: 'danger',
  head: 'info'
}

const methods = [
  {
    label: 'get',
    value: 'get'
  },
  {
    label: 'post',
    value: 'post'
  },
  {
    label: 'put',
    value: 'put'
  },
  {
    label: 'delete',
    value: 'delete'
  },
  {
    label: 'patch',
    value: 'patch'
  },
  {
    label: 'head',
    value: 'head'
  }
]
</script>
