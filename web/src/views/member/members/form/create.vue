<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="用户名"
      prop="username"
      :rules="[
        {
          required: true,
          message: '用户名必须填写'
        }
      ]"
    >
      <el-input v-model="formData.username" name="username" clearable />
    </el-form-item>
    <el-form-item
      label="邮箱"
      prop="email"
      :rules="[
        {
          required: true,
          message: '邮箱必须填写'
        }
      ]"
    >
      <el-input v-model="formData.email" name="email" clearable />
    </el-form-item>
    <el-form-item
      label="手机号"
      prop="mobile"
      :rules="[
        {
          required: true,
          message: '手机号必须填写'
        }
      ]"
    >
      <el-input v-model="formData.mobile" name="mobile" clearable />
    </el-form-item>
    <el-form-item
      label="密码"
      prop="password"
      :rules="[
        {
          required: passwordRequired,
          message: '密码必须填写'
        }
      ]"
    >
      <el-input v-model="formData.password" name="password" clearable />
    </el-form-item>
    <el-form-item label="头像" prop="avatar">
      <Upload imageClass="w-28 h-28 rounded-full mx-auto" v-model="formData.avatar" />
    </el-form-item>

    <el-form-item label="注册来源" prop="from">
      <el-select v-model="formData.from" placeholder="请选择" clearable class="w-full">
        <el-option v-for="item in froms" :key="item.value" :label="item.label" :value="item.value" />
      </el-select>
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

const passwordRequired = ref(true)
const froms = [
  { label: 'pc', value: 'pc' },
  { label: 'app', value: 'app' },
  { label: '小程序', value: 'miniprogram' }
]
const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)

if (props.primary) {
  useShow(props.api as string, props.primary, formData)

  passwordRequired.value = false
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
