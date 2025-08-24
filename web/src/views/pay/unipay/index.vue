<template>
  <div class="flex flex-col justify-center w-full bg-white item-center dark:bg-regal-dark">
    <el-form :model="pay" label-width="200px" ref="form" class="w-full mt-10 mb-10 md:w-1/2" v-loading="loading">
      <div class="flex justify-center w-full mb-5 text-lg text-gray-600">银联支付配置</div>

      <el-form-item label="商户号" prop="mch_id" :rules="[{ required: true, message: '商户号必须填写' }]">
        <el-input v-model="pay.mch_id" />
        <div>
          <Prompt text="银联支付分配的商户号" />
          <Prompt text="config('pay.unipay.mch_id')" />
        </div>
      </el-form-item>

      <el-form-item label="商户密钥" prop="mch_secret_key">
        <el-input v-model="pay.mch_secret_key" />
        <div>
          <Prompt text="商户密钥：为银联条码支付综合前置平台配置：https://up.95516.com/open/openapi?code=unionpay" />
          <Prompt text="config('pay.unipay.mch_secret_key')" />
        </div>
      </el-form-item>

      <el-form-item label="商户公私钥 " prop="mch_cert_path" :rules="[{ required: true, message: '请设置商户公私钥路径' }]">
        <el-input v-model="pay.mch_cert_path" />
        <div>
          <Prompt text="设置商户公私钥路径" />
          <Prompt text="config('pay.unipay.mch_cert_path')" />
        </div>
      </el-form-item>

      <el-form-item label="商户公私钥密码  " prop="mch_cert_password" :rules="[{ required: true, message: '请设置商户公私钥密码' }]">
        <el-input v-model="pay.mch_cert_password" />
        <div>
          <Prompt text="config('pay.unipay.mch_cert_password')" />
        </div>
      </el-form-item>

      <el-form-item label="银联公钥证书路径  " prop="unipay_public_cert_path" :rules="[{ required: true, message: '请设置银联公钥证书路径路径' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.unipay_public_cert_path" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/unipay" />

          <div>
            <Prompt text="设置银联公钥证书路径路径" />
            <Prompt text="config('pay.unipay.unipay_public_cert_path')" />
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
          <Prompt text="config('pay.unipay.return_url')" />
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
          <Prompt text="config('pay.unipay.notify_url')" />
        </div>
      </el-form-item>
      <div class="flex justify-center mt-2">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
      </div>
    </el-form>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import type { FormInstance } from 'element-plus'
import http from '@/support/http'
import Message from '@/support/message'
interface Unipay {
  mch_id: string // 必填-商户号
  mch_secret_key: string // 选填-商户密钥：为银联条码支付综合前置平台配置：https://up.95516.com/open/openapi?code=unionpay
  mch_cert_path: string //必填-应用公钥证书 路径 设置应用私钥后，即可下载得到以下3个证书
  mch_cert_password: string // 必填-支付宝公钥证书 路径
  unipay_public_cert_path: string // 必填-支付宝根证书 路径
  return_url: string
  notify_url: string
  mode: number // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
}

const pay = ref<Unipay>({
  mode: 0,
  mch_id: '',
  mch_secret_key: '',
  mch_cert_path: '',
  mch_cert_password: '',
  unipay_public_cert_path: '',
  return_url: '',
  notify_url: ''
})

const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('pay/config', { unipay: pay.value }).then(r => {
        Message.success('银联支付配置成功')
      })
    }
  })
}

http.get('pay/config/unipay').then(r => {
  Object.assign(pay.value, r.data.data)
})
</script>
