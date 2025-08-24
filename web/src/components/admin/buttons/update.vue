<template>
  <el-button type="primary" :size="size" text>
    <Icon :name="icon" className="w-4 h-4 mr-1" />
    {{ buttonText }}
  </el-button>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  size: {
    type: String,
    default: 'small'
  },
  icon: {
    type: String,
    default: 'pencil-square'
  },
  text: {
    type: String,
    default: ''
  }
})

const { t } = useI18n()

const buttonText = computed(() => {
  return props.text || t('system.update')
})
</script>

<style scoped></style>
