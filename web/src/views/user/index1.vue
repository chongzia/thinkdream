<template>
  <div class="flex flex-col sm:flex-row justify-between">
    <Department v-model="departmentQuery.department_id" @searchDepartmentUsers="searchDepartment" v-if="hasRoles" />
    <div :class="hasRoles ? 'w-[calc(100vw-5rem)] ml-0 sm:ml-2 mt-2 sm:mt-0' : 'w-full'">
      <div>
        <catch-table
          :columns="columns"
          :api="api"
          ref="tableRef"
          table-layout="fixed"
          :search-form="[
            {
              type: 'input',
              label: '用户名',
              name: 'username'
            },
            {
              type: 'input',
              label: '邮箱',
              name: 'email'
            },
            {
              type: 'select',
              label: '状态',
              name: 'status',
              api: 'status'
            }
          ]"
        >
          <template #avatar="{ row }">
            <el-avatar :src="row.avatar" />
          </template>
          <template #status="{ row }">
            <Status v-model="row.status" :id="row.id" :api="api" />
          </template>
          <!-- dialog -->
          <template #dialog="row">
            <Create :primary="row?.id" :api="api" :has-roles="hasRoles" />
          </template>
        </catch-table>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { onMounted, ref } from 'vue'
import Create from './create.vue'
import Department from './components/department.vue'
import { useUserStore } from '@/stores/modules/user'
import { isUndefined } from '@/support/helper'

const userStore = useUserStore()
const api = 'users'
const hasRoles = ref<boolean>(false)

onMounted(() => {
  hasRoles.value = !isUndefined(userStore.getRoles)
})

const tableRef = ref<any>()
// 部门搜索
const searchDepartment = () => {
  tableRef.value.doSearch({ department_id: departmentQuery.value.department_id }, true)
}
const departmentQuery = ref<Object>({})
const columns = [
  {
    type: 'selection'
  },
  {
    label: '用户昵称',
    prop: 'username'
  },
  {
    prop: 'avatar',
    label: '头像',
    slot: 'avatar',
    sortable: 'custom'
  },
  {
    label: '邮箱',
    prop: 'email'
  },
  {
    label: '状态',
    slot: 'status'
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
]
</script>
