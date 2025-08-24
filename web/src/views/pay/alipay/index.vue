<template>
  <div class="flex flex-col justify-center w-full bg-white item-center dark:bg-regal-dark">
    <el-form :model="pay" label-width="200px" ref="form" class="w-full mt-10 mb-10 md:w-1/2" v-loading="loading">
      <div class="flex justify-center w-full mb-5 text-lg text-gray-600">支付宝支付配置</div>

      <el-form-item label="app id" prop="app_id" :rules="[{ required: true, message: '支付宝分配的 app_id 必须填写' }]">
        <el-input v-model="pay.app_id" />
        <div>
          <Prompt text="支付宝分配的 app_id" />
          <Prompt text="config('pay.alipay.app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="应用私钥" prop="app_secret_cert" :rules="[{ required: true, message: '支付宝应用私钥' }]">
        <el-input v-model="pay.app_secret_cert" />
        <div>
          <Prompt text="字符串或路径, 在 https://open.alipay.com/develop/manage 《应用详情->开发设置->接口加签方式》中设置" />
          <Prompt text="config('pay.alipay.app_secret_cert')" />
        </div>
      </el-form-item>

      <el-form-item label="应用公钥证书 " prop="app_public_cert_path" :rules="[{ required: true, message: '请设置支付宝应用公钥证书路径' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.app_public_cert_path" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/alipay" />
          <div>
            <Prompt text="路径 设置应用私钥后，即可下载得到以下3个证书" />
            <Prompt text="config('pay.alipay.app_public_cert_path')" />
          </div>
        </div>
      </el-form-item>

      <el-form-item label="支付宝公钥证书  " prop="alipay_public_cert_path" :rules="[{ required: true, message: '请设置支付宝公钥证书路径' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.alipay_public_cert_path" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/alipay" />

          <div>
            <Prompt text="设置支付宝公钥证书路径" />
            <Prompt text="config('pay.alipay.app_public_cert_path')" />
          </div>
        </div>
      </el-form-item>

      <el-form-item label="支付宝根证书  " prop="alipay_root_cert_path" :rules="[{ required: true, message: '请设置支付宝根证书路径' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.alipay_root_cert_path" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/alipay" />

          <div>
            <Prompt text="设置支付宝根证书路径" />
            <Prompt text="config('pay.alipay.app_public_cert_path')" />
          </div>
        </div>
      </el-form-item>

      <el-form-item
        label="同步跳转地址"
        prop="return_url"
        :rules="[
          { required: true, message: '请设置同步跳转地址' },
          { type: 'url', message: '同步跳转地址格式不正确' }
        ]"
      >
        <el-input v-model="pay.return_url" />
        <div>
          <Prompt text="同步跳转地址 return url" />
          <Prompt text="config('pay.alipay.return_url')" />
        </div>
      </el-form-item>

      <el-form-item
        label="异步回调地址"
        prop="notify_url"
        :rules="[
          { required: true, message: '请设置异步回调地址' },
          { type: 'url', message: '异步回调地址格式不正确' }
        ]"
      >
        <el-input v-model="pay.notify_url" />
        <div>
          <Prompt text="异步回调地址 notify url" />
          <Prompt text="config('pay.alipay.notify_url')" />
        </div>
      </el-form-item>

      <el-form-item label="第三方应用授权token">
        <el-input v-model="pay.app_auth_token" />
        <div>
          <Prompt text="异步回调地址 notify url" />
          <Prompt text="config('pay.alipay.app_auth_token')" />
        </div>
      </el-form-item>

      <el-form-item label="模式">
        <div class="flex flex-col">
          <el-radio-group v-model="pay.mode">
            <el-radio :value="0">正常模式</el-radio>
            <el-radio :value="1">沙箱模式</el-radio>
            <el-radio :value="2">服务商模式</el-radio>
          </el-radio-group>

          <div>
            <Prompt text="config('pay.alipay.mode')" />
          </div>
        </div>
      </el-form-item>

      <el-form-item label="服务商 id" v-if="pay.mode === 2">
        <el-input v-model="pay.service_provider_id" />
        <div>
          <Prompt text="服务商模式下的服务商 id" />
          <Prompt text="config('pay.alipay.service_provider_id')" />
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
interface Alipay {
  app_id: string // 必填-支付宝分配的 app_id
  app_secret_cert: string // 必填-应用私钥 字符串或路径 在 https://open.alipay.com/develop/manage 《应用详情->开发设置->接口加签方式》中设置
  app_public_cert_path: string //必填-应用公钥证书 路径 设置应用私钥后，即可下载得到以下3个证书
  alipay_public_cert_path: string // 必填-支付宝公钥证书 路径
  alipay_root_cert_path: string // 必填-支付宝根证书 路径
  return_url: string
  notify_url: string
  app_auth_token: string // 选填-第三方应用授权token
  service_provider_id: string // 选填-服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数
  mode: number // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
}

const pay = ref<Alipay>({
  app_id: '',
  app_secret_cert: '',
  app_public_cert_path: '',
  alipay_public_cert_path: '',
  alipay_root_cert_path: '',
  return_url: '',
  notify_url: '',
  app_auth_token: '',
  service_provider_id: '',
  mode: 0
})

const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('pay/config', { alipay: pay.value }).then(r => {
        Message.success('支付宝配置成功')
      })
    }
  })
}

http.get('pay/config/alipay').then(r => {
  Object.assign(pay.value, r.data.data)
})
</script>
