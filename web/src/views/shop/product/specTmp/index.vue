<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" dialogWidth="1200px">
      <template #specs="scope">
        <div class="grid grid-cols-8 gap-1">
          <el-button text bg type="primary" v-for="spec in scope.row.specs" :key="spec.id">{{ spec.name }}</el-button>
        </div>
      </template>
      <template #values="scope">
        <div class="w-full" v-for="spec in scope.row.specs" :key="spec.id">
          <div class="w-full mt-2">
            <div class="flex gap-x-2 w-full">
              <div class="w-16">规格:</div>
              <el-text type="success" size="large">{{ spec.name }}</el-text>
            </div>
            <div class="flex gap-x-2 w-full">
              <div class="w-16">规格值:</div>
              <div class="grid grid-cols-6 gap-2 w-full">
                <el-tag v-for="value in spec.values" :key="value.id" effect="plain" round>{{ value.value }}</el-tag>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
const api = 'shop/product/spec/tmp'

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'name',
    label: '模版名称',
    width: 200
  },
  {
    prop: 'specs',
    label: '规格'
  },
  {
    prop: 'values',
    label: '规格值'
  },
  {
    prop: 'created_at',
    label: '创建时间',
    width: 200
  },
  {
    type: 'operate',
    label: '操作',
    width: 250
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'name',
    label: '模版名称'
  }
]
</script>
