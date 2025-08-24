<template>
  <el-form-item label="监控频率">
    <el-select v-model="frequency" placeholder="选择频次">
      <el-option v-for="item in frequencies" :key="item.value" :label="item.label" :value="item.value" />
    </el-select>
    <Prompt :text="prompt" />
  </el-form-item>
</template>
<script lang="ts" setup>
const frequency = defineModel<number>()

defineProps({
  prompt: {
    type: String,
    default: ''
  }
})
const frequencies = [
  {
    label: '五分钟',
    value: 5
  },
  {
    label: '十分钟',
    value: 10
  },
  {
    label: '十五分钟',
    value: 15
  },
  {
    label: '三十分钟',
    value: 30
  }
]
</script>
