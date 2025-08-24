<template>
  <div class="flex flex-col w-full p-5 bg-white dark:bg-regal-dark">
    <el-tabs v-model="activeName" @tab-click="handleClick">
      <el-tab-pane label="物流配置" name="logistic">
        <Logistic />
      </el-tab-pane>
    </el-tabs>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import type { TabsPaneContext } from 'element-plus'
import Logistic from './components/Logistic.vue'
const activeName = ref('logistic')

const handleClick = (tab: TabsPaneContext, event: Event) => {
  console.log(tab, event)
}
</script>
