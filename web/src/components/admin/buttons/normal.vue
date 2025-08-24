<template>
  <el-button :type="type" :size="size" :class="className">
    <Icon :name="icon" v-if="icon" :class="iconClass" />
    {{ buttonLabel }}
  </el-button>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  className: {
    type: String,
    default: ''
  },
  iconClass: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'primary'
  },
  size: {
    type: String,
    default: 'default'
  },
  icon: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: ''
  }
})

const { t } = useI18n()

const buttonLabel = computed(() => {
  return props.label || t('system.add')
})
</script>
