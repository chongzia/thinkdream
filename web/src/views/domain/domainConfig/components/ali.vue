<template>
  <el-card class="w-1/3">
    <template #header>
      <div class="flex justify-between">
        <span>阿里云域名配置</span>
      </div>
    </template>
    <div>
      <el-alert type="success" center>
        <a href="https://ram.console.aliyun.com/manage/ak" target="_blank"> 阿里云域名配置密钥获取 </a>
      </el-alert>
      <el-form :model="aliyun" label-width="100px" ref="aliyunForm" class="mt-5">
        <el-form-item
          label="AccessKey"
          :rules="[
            {
              required: true,
              message: 'AccessKey 必须填写'
            }
          ]"
          prop="access_key"
        >
          <el-input v-model="aliyun.access_key" placeholder="access_key" />
          <Prompt text="config('domain.aliyun.access_key')" />
        </el-form-item>
        <el-form-item
          label="密钥"
          :rules="[
            {
              required: true,
              message: '密钥 必须填写'
            }
          ]"
          prop="access_secret"
        >
          <el-input v-model="aliyun.access_secret" placeholder="密钥" />
          <Prompt text="config('domain.aliyun.access_secret')" />
        </el-form-item>
      </el-form>
      <div class="flex justify-end w-full">
        <el-button type="primary" @click="submitForm(aliyunForm)">保存</el-button>
      </div>
    </div>
  </el-card>
</template>
<script lang="ts" setup>
import { onMounted, ref } from 'vue'
import http from '@/support/http'
import Message from '@/support/message'
import type { FormInstance } from 'element-plus'

// 阿里云配置
const aliyun = ref({
  type: 'aliyun',
  access_key: '',
  access_secret: ''
})

const getAliyun = () => {
  // 获取阿里云配置
  http.get('system/domain/config').then(r => {
    if (r.data.code === 1e4 && typeof r.data.data === 'object') {
      aliyun.value.access_key = r.data.data.aliyun.access_key
      aliyun.value.access_secret = r.data.data.aliyun.access_secret
    }
  })
}

const aliyunForm = ref<FormInstance>()
const submitForm = async (formEl: FormInstance | undefined) => {
  if (!formEl) return
  await formEl.validate((valid, fields) => {
    if (valid) {
      http.post('system/domain/config', aliyun).then(r => {
        Message.success('阿里云域名配置成功')
      })
    }
  })
}

onMounted(() => {
  getAliyun()
})
</script>
<style scoped>
:deep(.template > .el-dialog__body) {
  padding: 0 !important;
}
</style>
