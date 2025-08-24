<template>
  <div>
    <el-alert title="启用该功能，需要在服务器 cron 添加这条规则 * * * * * cd /你的项目地址 && php artisan schedule:run >> /dev/null 2>&1" type="success" />

    <catch-table :columns="columns" :api="api" :search-form="search" class="mt-2">
      <template #operation>
        <router-link :to="{ path: '/system/cron/log' }">
          <el-button class="ml-3">日志</el-button>
        </router-link>
      </template>
      <template #status="scope">
        <el-tag v-if="scope.row.status === 1" type="info">未运行</el-tag>
        <el-tag v-if="scope.row.status === 2" type="success">运行中</el-tag>
      </template>

      <template #times="scope">
        <el-tag type="success">{{ scope.row.success_times }}</el-tag> / <el-tag type="danger">{{ scope.row.failed_times }}</el-tag>
      </template>

      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'system/cron/tasks'
// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 80
  },
  {
    prop: 'name',
    label: '任务名称'
  },
  {
    prop: 'command',
    label: '任务命令'
  },
  {
    prop: 'run_at',
    label: '运行开始于',
    filter: (value: number) => {
      return new Date(value * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ')
    }
  },
  {
    label: '耗时 / s',
    prop: 'consuming',
    align: 'center',
    width: 100
  },
  {
    prop: 'is_overlapping',
    label: '成功/失败(次)',
    slot: 'times',
    align: 'center'
  },
  {
    prop: 'status',
    label: '状态',
    slot: 'status',
    width: 100
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
    label: '任务名称'
  },
  {
    type: 'input',
    name: 'command',
    label: '任务命令'
  }
]
</script>
<style scoped>
:deep(.el-alert--success) {
  @apply flex justify-center;
}
</style>
