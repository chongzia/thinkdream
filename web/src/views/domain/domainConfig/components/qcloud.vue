<template>
  <el-card class="w-1/3">
    <template #header>
      <div class="flex justify-between">
        <span>腾讯云域名配置</span>
      </div>
    </template>
    <div>
      <el-alert type="success" center>
        <a href="https://console.cloud.tencent.com/cam/capi" target="_blank"> 腾讯云域名配置密钥获取 </a>
      </el-alert>

      <el-form :model="qcloud" label-width="100px" class="mt-5" ref="qcloudForm">
        <el-form-item
          label="SecretId"
          prop="secret_id"
          :rules="[
            {
              required: true,
              message: 'AppID 必须填写'
            }
          ]"
        >
          <el-input v-model="qcloud.secret_id" placeholder="secret_id" />
          <Prompt text="config('domain.qcloud.secret_id')" />
        </el-form-item>
        <el-form-item
          label="密钥"
          prop="secret_key"
          :rules="[
            {
              required: true,
              message: 'secret_key 必须填写'
            }
          ]"
        >
          <el-input v-model="qcloud.secret_key" placeholder="密钥" />
          <Prompt text="config('domain.qcloud.secret_key')" />
        </el-form-item>
      </el-form>
      <div class="flex justify-end w-full">
        <el-button type="primary" @click="submitForm(qcloudForm)">保存</el-button>
      </div>
    </div>
  </el-card>
</template>
<script lang="ts" setup>
import { onMounted, ref } from 'vue'
import http from '@/support/http'
import Message from '@/support/message'
import type { FormInstance } from 'element-plus'

// 腾讯短信配置
const qcloud = ref({
  type: 'qcloud',
  secret_id: '',
  secret_key: ''
})

// 腾讯云
const getQcolud = () => {
  http.get('system/domain/config').then(r => {
    if (r.data.code === 1e4 && typeof r.data.data === 'object') {
      qcloud.value.secret_id = r.data.data.qcloud.secret_id
      qcloud.value.secret_key = r.data.data.qcloud.secret_key
    }
  })
}
const qcloudForm = ref<FormInstance>()
const submitForm = async (formEl: FormInstance | undefined) => {
  if (!formEl) return
  await formEl.validate((valid, fields) => {
    if (valid) {
      http.post('system/domain/config', qcloud).then(r => {
        Message.success('腾讯云域名配置成功')
      })
    }
  })
}
onMounted(() => {
  getQcolud()
})
</script>

<style scoped>
:deep(.template > .el-dialog__body) {
  padding: 0 !important;
}
</style>
