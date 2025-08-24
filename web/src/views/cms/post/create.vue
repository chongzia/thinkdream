<!-- eslint-disable vue/valid-v-for -->
<template>
  <div class="w-full px-5 pt-5 pr-4 bg-white dark:bg-regal-dark">
    <catch-form
      ref="formRef"
      :is-page="true"
      :beforeSubmit="beforeSubmit"
      :config="{ rules: form.rules, options: form.options, api: table.api, primary: primary }"
      v-if="!loading"
      :afterSubmit="afterSubmit"
    />
  </div>
</template>
<script lang="ts" setup>
// @ts-nocheck
import http from '@/support/http'
import { onMounted, ref, beforeMount, watch } from 'vue'
import { useDynamic } from '@/composables/useDynamic'
import router from '@/router'

const formRef = ref()
const { table, form, loading } = useDynamic('cms/post/dynamic/r')
const primary = ref(null)
primary.value = router.currentRoute.value.params.id

const beforeSubmit = formData => {
  formData.category_id = formData.category_id ? formData.category_id[0] : 0
  return formData
}

const afterSubmit = () => {
  router.push({ path: '/cms/articles/post' })
}
</script>
<style scoped>
:deep(.el-loading-mask) {
  z-index: 10000 !important;
}

:deep(.tox) {
  z-index: 99 !important;
}

:deep(.fc-form-footer) {
  @apply flex justify-center !important;
}
</style>
