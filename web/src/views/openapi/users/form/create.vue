<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="用户名" prop="username" :rules="[{ required: true, message: '请输入用户名' }]">
      <el-input v-model="formData.username" name="username" clearable placeholder="请输入用户名" />
    </el-form-item>
    <el-form-item label="手机号" prop="mobile" :rules="[{ required: true, message: '请输入手机号' }]">
      <el-input v-model="formData.mobile" name="mobile" clearable placeholder="请输入手机号" />
    </el-form-item>
    <el-form-item label="密码" prop="password" :rules="[{ required: !primary, message: '请输入密码' }]">
      <el-input v-model="formData.password" name="password" clearable placeholder="请输入密码" type="password" />
    </el-form-item>
    <el-form-item label="QPS" prop="qps" :rules="[{ required: true, message: '请输入每分钟 QPS' }]">
      <el-input-number v-model="formData.qps" name="qps" clearable placeholder="请输入每分钟的 QPS" :min="10" />
    </el-form-item>
    <el-form-item label="公司名称" prop="company">
      <el-input v-model="formData.company" name="company" clearable placeholder="请输入公司名称" />
    </el-form-item>
    <el-form-item label="描述" prop="description">
      <el-input v-model="formData.description" name="description" clearable placeholder="请输入描述" type="textarea" />
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
