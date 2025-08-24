<template>
  <div>
    <catch-table
      :columns="[
        {
          label: 'ID',
          prop: 'id',
          width: 100
        },
        {
          label: '字段名称',
          prop: 'column_name'
        },
        {
          label: '创建时间',
          prop: 'created_at'
        },
        {
          type: 'operate',
          label: '操作',
          width: 200,
          update: false
        }
      ]"
      :default-params="{ table: table }"
      :showHeader="false"
      :api="api"
      :pagination="false"
    />
  </div>
</template>

<script lang="ts" setup>
// @ts-nocheck
const api = 'system/schema/field/management'
defineProps({
  table: String
})
</script>
