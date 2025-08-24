<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
      <template #operate="scope">
        <router-link :to="`/domain/records/${scope.row.id}/${scope.row.name}`">
          <el-button type="success" size="small" text> 解析 </el-button>
        </router-link>
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'domain/domains'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'name',
    label: '域名'
  },
  {
    prop: 'type',
    label: '所属服务商',
    filter: (value: string) => {
      return value === 'aliyun' ? '阿里云' : '腾讯云'
    }
  },
  {
    prop: 'name_servers',
    label: '域名解析服务器'
  },
  {
    prop: 'expired_at',
    label: '过期时间'
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    prop: 'remark',
    label: '备注'
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
    label: '域名'
  }
]
</script>
