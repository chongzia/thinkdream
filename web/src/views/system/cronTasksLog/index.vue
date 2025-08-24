<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" :operation="false">
      <template #operation>
        <router-link :to="{ path: '/system/cron/tasks' }">
          <el-button>返回</el-button>
        </router-link>
      </template>
      <template #consuming="scope">
        <el-tag type="success">{{ scope.row.consuming }}</el-tag>
      </template>
      <template #status="scope">
        <el-tag v-if="scope.row.status === 1" type="success">成功</el-tag>
        <el-tag v-if="scope.row.status === 2" type="danger">失败</el-tag>
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
const api = 'system/cron/log'

// table columns
const columns = [
  {
    type: 'selection'
  },
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'task_id',
    label: '任务ID',
    width: 100
  },
  {
    prop: 'start_at',
    label: '开始时间'
  },
  {
    prop: 'end_at',
    label: '结束时间'
  },
  {
    label: '耗时 / s',
    prop: 'consuming',
    align: 'center',
    width: 100
  },
  {
    prop: 'status',
    label: '状态',
    align: 'center',
    width: 150
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    type: 'operate',
    label: '操作',
    update: false
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'task_id',
    label: '任务ID'
  },
  {
    type: 'date',
    name: 'start_at',
    label: '开始时间'
  },
  {
    type: 'date',
    name: 'end_at',
    label: '结束时间'
  }
]
</script>
