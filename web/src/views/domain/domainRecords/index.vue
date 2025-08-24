<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" ref="table">
      <template #dialog="row">
        <Create :primary="row?.recordid" api="domain/domain/records" :domain="domain" :domain-id="id" />
      </template>
      <template #operate="scope">
        <Destroy @click="destroy(('domain/domain/records/' + scope.row.recordid + '?domain=' + domain) as string, '')" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
import router from '@/router'
import { useDestroy } from '@/composables/curd/useDestroy'
import { onMounted, ref } from 'vue'

const domain = router.currentRoute.value.params.name as string
const id = parseInt(router.currentRoute.value.params.id as string)

const api = `domain/domain/records?id=${id}&name=${domain}`

// table columns
const columns = [
  {
    prop: 'recordid',
    label: 'ID',
    width: 150
  },
  {
    prop: 'name',
    label: '主机记录'
  },
  {
    prop: 'type',
    label: '记录类型'
  },
  {
    prop: 'value',
    label: '记录值'
  },
  {
    prop: 'ttl',
    label: 'TTL/秒'
  },
  {
    prop: 'updatedon',
    label: '更新时间'
  },
  {
    prop: 'remark',
    label: '备注'
  },
  {
    type: 'operate',
    label: '操作',
    destroy: false
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

const table = ref()
// 删除
const { destroy, deleted } = useDestroy('确定删除改域名解析吗')
// onMounted
onMounted(() => {
  deleted(table.value.reset)
})
</script>
