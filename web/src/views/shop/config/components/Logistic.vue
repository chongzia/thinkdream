<template>
  <div>
    <el-divider content-position="left">全球物流查询接口配置</el-divider>
    <el-form :model="logistic" label-width="200px" ref="form" v-loading="loading" class="w-1/2 mt-10 mb-10">
      <el-alert type="warning" class="flex items-center justify-center w-full">
        <template #title>
          <div class="">
            全球物流查询接口<span class="text-indigo-600"><a :href="golbalApi" target="_blank">配置获取</a></span>
          </div>
        </template>
      </el-alert>
      <el-form-item label="接口 Host" prop="global.host" class="mt-2" :rules="[{ required: true, message: '请输入接口 host' }]">
        <div class="flex flex-col w-full">
          <div>
            <el-input v-model="logistic.global.host" placeholder="请输入接口 host" />
          </div>
          <div>
            <Prompt text="config('logistic.global.host')" />
          </div>
        </div>
      </el-form-item>
      <el-form-item label="接口 token" prop="global.token" :rules="[{ required: true, message: '请输入接口 token' }]">
        <div class="flex flex-col w-full">
          <div>
            <el-input v-model="logistic.global.token" placeholder="请输入接口 token" />
          </div>
          <div>
            <Prompt text="config('logistic.global.token')" />
          </div>
        </div>
      </el-form-item>
      <div class="flex justify-center mt-2">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
      </div>
    </el-form>
  </div>
</template>
<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import type { FormInstance } from 'element-plus'
import http from '@/support/http'
import Message from '@/support/message'
const logistic = ref({
  global: {
    host: '',
    token: ''
  }
})
const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('shop/config/logistics', logistic.value).then(r => {
        Message.success('物流配置成功')
      })
    }
  })
}

onMounted(() => {
  http.get('shop/config/logistics').then(r => {
    logistic.value = Object.assign(logistic.value, r.data.data)
  })
})

const golbalApi = 'https://market.aliyun.com/products/57002002/cmapi023201.html'
</script>
