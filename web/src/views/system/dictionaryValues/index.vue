<template>
  <div>
    <catch-table
      :key="tableKey"
      :default-params="{
        dic_id: dicId
      }"
      :columns="[
        {
          label: 'ID',
          prop: 'id'
        },
        {
          label: '字典值名称',
          prop: 'label'
        },
        {
          label: '字典值键名',
          prop: 'key'
        },
        {
          label: '字典键值',
          prop: 'value'
        },
        {
          label: '排序',
          prop: 'sort'
        },
        {
          label: '状态',
          prop: 'status',
          slot: 'status'
        },
        {
          label: '描述',
          prop: 'description'
        },
        {
          label: '创建时间',
          prop: 'created_at'
        },
        {
          type: 'operate',
          label: '操作',
          width: 200
        }
      ]"
      :api="api"
      :search-form="[
        {
          type: 'input',
          label: '字典值名',
          name: 'label'
        },
        {
          type: 'select',
          label: '状态',
          name: 'status',
          api: 'status'
        }
      ]"
    >
      <template #status="scope">
        <Status v-model="scope.row.status" :id="scope.row.id" :api="api" />
      </template>
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import Create from './form/create.vue'

const route = useRoute()
const api = 'system/dic/values'

// 使用响应式的路由参数
const dicId = computed(() => route.params.id)

// 当路由参数改变时，重新加载数据
const tableKey = ref(0)
watch(() => route.params.id, () => {
  // 强制重新渲染表格组件以重新加载数据
  tableKey.value++
}, { immediate: true })
</script>
