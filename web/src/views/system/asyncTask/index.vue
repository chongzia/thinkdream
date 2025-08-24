<template>
  <div>
    <catch-table :columns="columns" api="system/async/task" :operation="false" />
  </div>
</template>

<script lang="ts" setup>
// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'task',
    label: '任务名称'
  },
  {
    prop: 'params',
    label: '参数'
  },
  {
    prop: 'start_at',
    label: '开始时间'
  },
  {
    prop: 'status',
    label: '状态',
    tags: ['default', 'info', 'danger', 'success'],
    filter: (value: number) => {
      return value === 1 ? '未开始' : value === 2 ? '执行中' : value === 2 ? '失败' : '成功'
    }
  },
  {
    prop: 'time_taken',
    label: '耗时/s'
  },
  {
    prop: 'error',
    label: '错误'
  },
  {
    prop: 'result',
    label: '结果',
    link: true
  },
  {
    prop: 'retry',
    label: '重试次数'
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  /** {
    prop: 'updated_at',
    label: '更新时间'
  }, */
  {
    type: 'operate',
    update: false,
    label: '操作'
  }
]
</script>
