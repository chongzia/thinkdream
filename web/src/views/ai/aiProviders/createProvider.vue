<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="服务商名称" prop="title" :rules="[{ required: true, message: '请输入服务商名称' }]">
      <el-input v-model="formData.title" clearable placeholder="请输入服务商名称" />
    </el-form-item>
    <el-form-item label="服务商logo" prop="logo" :rules="[{ required: true, message: '请上传服务商logo' }]">
      <Upload v-model="formData.logo" />
    </el-form-item>
    <el-form-item label="服务商提供者" prop="provider" :rules="[{ required: true, message: '请输入服务商提供者' }]">
      <Select api="aiProviders" v-model="formData.provider" clearable placeholder="请选择服务商提供者" />
    </el-form-item>
    <el-form-item label="API Key" prop="app_key" :rules="[{ required: true, message: '请输入服务商API Key' }]">
      <el-input v-model="formData.app_key" clearable placeholder="请输入服务商API Key" />
    </el-form-item>
    <el-form-item
      label="服务地址"
      prop="api_url"
      :rules="[
        { required: true, message: '请输入服务地址称' },
        { type: 'url', message: '请输入正确的服务地址' }
      ]"
    >
      <el-input v-model="formData.api_url" clearable placeholder="请输入服务地址" />
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

const emits = defineEmits(['close'])
onMounted(() => {
  close(() => emits('close'))
})
</script>
