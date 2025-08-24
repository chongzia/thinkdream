<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" ref="table">
      <template #operate="scope">
        <Update text="字段权限" @click="open(scope.row.table_name)" />
        <Destroy icon="code-bracket" text="字段管理" @click="openFieldManage(scope.row.table_name)" v-if="scope.row.has_role_columns" />
      </template>
    </catch-table>
    <Dialog v-model="fieldVisible" width="1000px" title="字段权限配置" destroy-on-close>
      <Fields :api="api" :table="tableName" />
    </Dialog>

    <Dialog v-model="fieldManage" width="1000px" title="权限字段管理" destroy-on-close>
      <FieldManage :table="tableName" />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import Fields from './fields.vue'
import FieldManage from './fieldManage.vue'

const api = 'system/schema'
const fieldVisible = ref(false)
const fieldManage = ref(false)
const tableName = ref()
// table columns
const columns = [
  {
    prop: 'table_name',
    label: '表名'
  },
  {
    prop: 'engine',
    label: '表引擎'
  },
  {
    prop: 'table_rows',
    label: '总行数'
  },
  {
    prop: 'data_length',
    label: '数据大小'
  },
  {
    prop: 'index_length',
    label: '索引大小'
  },
  {
    prop: 'table_collation',
    label: '字符集'
  },
  {
    prop: 'table_comment',
    label: '表注释'
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    type: 'operate',
    label: '操作',
    update: false,
    destroy: false
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'name',
    label: '表名'
  }
]

const open = (name: string) => {
  fieldVisible.value = true
  tableName.value = name
  console.log(name)
}

const openFieldManage = (name: string) => {
  fieldManage.value = true
  tableName.value = name
  console.log(name)
}
</script>
