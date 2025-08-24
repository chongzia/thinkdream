<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="规格名称" prop="name">
      <el-input v-model="formData.name" name="name" clearable />
    </el-form-item>
    <el-form-item label="创建时间" prop="created_at">
      <el-input-number v-model="formData.created_at" name="created_at" :min="1" />
    </el-form-item>
    <div class="flex justify-end">
      <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
    </div>
  </el-form>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { useCreate } from '@/composables/curd/useCreate'
import { useShow } from '@/composables/curd/useShow'

import { inject, onMounted } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
