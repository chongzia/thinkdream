<template>
  <el-table :data="tableData" style="width: 100%" v-loading="loading">
    <el-table-column prop="name" label="字段名称" width="180" />
    <el-table-column label="字段可读">
      <template #default="scope">
        <el-tree-select
          :data="roles"
          multiple
          placeholder="请选择角色"
          v-model="scope.row.readable_roles"
          node-key="id"
          show-checkbox
          check-strictly
          :render-after-expand="false"
          :props="{ value: 'id', label: 'role_name', multiple: true }"
        />
      </template>
    </el-table-column>
    <el-table-column label="字段可写">
      <template #default="scope">
        <el-tree-select
          :data="roles"
          multiple
          placeholder="请选择角色"
          v-model="scope.row.writeable_roles"
          node-key="id"
          show-checkbox
          check-strictly
          :render-after-expand="false"
          :props="{ value: 'id', label: 'role_name', multiple: true }"
        />
      </template>
    </el-table-column>
    <el-table-column prop="type" label="字段类型" width="180" />
    <el-table-column prop="comment" label="注释" />
  </el-table>

  <div class="flex justify-center w-full mt-5">
    <Add text="提交" @click="submit()" />
  </div>
</template>

<script lang="ts" setup>
import http from '@/support/http'
import Message from '@/support/message'
import { ref } from 'vue'

// @ts-nocheck
const props = defineProps({
  table: String,
  api: String
})

const roles = ref([])
const tableData = ref([])
const loading = ref(true)
http.get(props.api + '/fields/' + props.table).then(r => {
  loading.value = false
  tableData.value = r.data.data
})

const getRoles = () => {
  http.get('permissions/roles').then(r => {
    roles.value = r.data.data
  })
}

getRoles()

const submit = () => {
  http.post('system/schema/fields/role/visible', { columns: tableData.value, table: props.table }).then(r => {
    Message.success('操作成功')
  })
}
</script>
