<template>
  <el-button type="primary" :size="size">
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
    default: 'default'
  },
  icon: {
    type: String,
    default: 'plus'
  },
  text: {
    type: String,
    default: ''
  }
})

const { t } = useI18n()

const buttonText = computed(() => {
  return props.text || t('system.add')
})
</script>
