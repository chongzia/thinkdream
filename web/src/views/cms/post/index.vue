<template>
  <div v-loading="loading" class="min-h-96">
    <catch-table v-bind="table" v-if="!loading" ref="tableRef">
      <template #operation>
        <el-button-group class="ml-2">
          <el-button
            plain
            class="border-gray-200"
            @click="searchType(item.value)"
            v-for="item in [
              { label: '文章', value: 1 },
              { label: '单页', value: 2 }
            ]"
            :key="item.value"
            >{{ item.label }}</el-button
          >
        </el-button-group>
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { useDynamic } from '@/composables/useDynamic'
const { table, form, loading } = useDynamic('cms/post/dynamic/r')
const tableRef = ref()
const searchType = (val: number) => {
  tableRef.value.doSearch({
    type: val
  })
}
</script>
