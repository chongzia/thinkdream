<template>
  <el-form-item label="是否开启">
    <div class="flex flex-col">
      <el-radio-group v-model="enable">
        <el-radio
          :value="item.value"
          v-for="item in [
            {
              label: '开启',
              value: true
            },
            {
              label: '关闭',
              value: false
            }
          ]"
          :key="item.label"
          >{{ item.label }}</el-radio
        >
      </el-radio-group>
      <div>
        <Prompt :text="prompt" />
      </div>
    </div>
  </el-form-item>
</template>
<script lang="ts" setup>
const enable = defineModel()

defineProps({
  prompt: {
    type: String,
    default: ''
  }
})
</script>
