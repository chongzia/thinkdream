<template>
  <div class="flex flex-col items-center justify-center w-full bg-white dark:bg-regal-dark">
    <el-form :model="formData" label-width="200px" ref="form" class="w-1/2 mt-10 mb-10">
      <span class="text-lg">系统基本设置</span>

      <el-divider content-position="left">基础设置</el-divider>
      <el-form-item
        label="后台标题"
        :rules="[
          {
            required: true,
            message: '请输入后台标题'
          }
        ]"
      >
        <div class="w-full md:w-1/2">
          <el-input v-model="formData.dashboard.name" class="w-full" placeholder="请输入后台标题" />
          <Prompt text="config('setting.dashboard.name')" />
        </div>
      </el-form-item>
      <el-form-item
        label="后台 Logo"
        :rules="[
          {
            required: true,
            message: '请上传后台 Logo'
          }
        ]"
      >
        <div class="flex flex-col">
          <UploadImage v-model="formData.dashboard.logo" class="w-36" />
          <Prompt text="config('setting.dashboard.logo')" />
        </div>
      </el-form-item>
      <el-divider content-position="left">登录</el-divider>

      <el-form-item label="开启微信登录">
        <div>
          <el-radio-group v-model="formData.login.wechat">
            <el-radio :value="1">是</el-radio>
            <el-radio :value="0">否</el-radio>
          </el-radio-group>
          <Prompt text="config('setting.login.wechat')" />
          <Prompt text="先到[系统管理->微信配置->微信开放平台]配置对应的网站应用配置后，再启用，否则无效" />
        </div>
      </el-form-item>
      <el-form-item label="开启手机号登录">
        <div>
          <el-radio-group v-model="formData.login.mobile">
            <el-radio :value="1">是</el-radio>
            <el-radio :value="0">否</el-radio>
          </el-radio-group>
          <Prompt text="config('setting.login.mobile')" />
          <Prompt text="先到[系统管理->短信配置]配置好短信，再启用，否则无效" />
        </div>
      </el-form-item>
      <el-form-item label="开启验证码">
        <div>
          <el-radio-group v-model="formData.login.use_captcha">
            <el-radio :value="1">是</el-radio>
            <el-radio :value="0">否</el-radio>
          </el-radio-group>
          <Prompt text="config('setting.login.use_captcha')" />
          <Prompt text="后台是否使用验证码校验" />
        </div>
      </el-form-item>
      <div class="flex justify-center">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
      </div>
    </el-form>
  </div>
</template>
<script lang="ts" setup>
// @ts-nocheck
import { ref, onMounted } from 'vue'
import http from '@/support/http'
import Message from '@/support/message'
import type { FormInstance } from 'element-plus'
import { useAppStore } from '@/stores/modules/app'
import router from '@/router'
const api: string = 'system/setting'
const appStore = useAppStore()

const formData = ref({
  dashboard: {
    name: '',
    logo: ''
  },
  login: {
    mobile: 0,
    wechat: 0,
    use_captcha: 1
  }
})
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate((valid, fields) => {
    if (valid) {
      http.post(api, formData.value).then(r => {
        appStore.setSetting(formData.value)
        Message.success('配置成功')
      })
    }
  })
}

onMounted(() => {
  const { dashboard, login } = appStore.getSetting
  formData.value.dashboard.logo = dashboard.logo
  formData.value.dashboard.name = dashboard.name
  formData.value.login.mobile = login.mobile
  formData.value.login.wechat = login.wechat
  formData.value.login.use_captcha = login.use_captcha
})
</script>
