<template>
  <div class="flex flex-col justify-center w-full bg-white item-center dark:bg-regal-dark">
    <el-form :model="pay" label-width="200px" ref="form" class="w-full mt-10 mb-10 md:w-1/2" v-loading="loading">
      <div class="flex justify-center w-full mb-5 text-lg text-gray-600">微信支付配置</div>

      <el-form-item label="模式">
        <div class="flex flex-col">
          <el-radio-group v-model="pay.mode">
            <el-radio :value="0">普通模式</el-radio>
            <el-radio :value="2">服务商模式</el-radio>
          </el-radio-group>

          <div>
            <Prompt text="config('pay.wechat.mode')" />
          </div>
        </div>
      </el-form-item>
      <el-form-item :label="pay.mode ? '服务商商户号' : '商户号'" prop="mch_id" :rules="[{ required: true, message: (pay.mode ? '服务商商户号' : '商户号') + '必须填写' }]">
        <el-input v-model="pay.mch_id" />
        <div>
          <Prompt text="商户号，服务商模式下为服务商商户号" />
          <Prompt text="config('pay.wechat.mch_id')" />
        </div>
      </el-form-item>

      <el-form-item label="v2商户私钥" prop="mch_secret_key_v2">
        <el-input v-model="pay.mch_secret_key_v2" />
        <div>
          <Prompt text="config('pay.wechat.mch_secret_key_v2')" />
        </div>
      </el-form-item>

      <el-form-item label="v3 商户秘钥 " prop="mch_secret_key" :rules="[{ required: true, message: '请填写 v3 商户秘钥' }]">
        <el-input v-model="pay.mch_secret_key" />
        <div>
          <Prompt text="API v3 密钥(32字节，形如md5值)，可在 账户中心->API安全 中设置" />
          <Prompt text="config('pay.wechat.mch_secret_key')" />
        </div>
      </el-form-item>

      <el-form-item label="商户私钥  " prop="mch_secret_cert" :rules="[{ required: true, message: '请设置商户私钥' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.mch_secret_cert" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/wechat" />
          <div>
            <Prompt text="API证书 PRIVATE KEY，可在 账户中心->API安全->申请API证书 里获得 文件名形如：apiclient_key.pem" />
            <Prompt text="config('pay.wechat.mch_secret_cert')" />
          </div>
        </div>
      </el-form-item>

      <el-form-item label="商户公钥证书路径" prop="mch_public_cert_path" :rules="[{ required: true, message: '请设置商户公钥证书路径' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.mch_public_cert_path" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/wechat" />
          <div>
            <Prompt text="API证书 CERTIFICATE，可在 账户中心->API安全->申请API证书 里获得 文件名形如：apiclient_cert.pem" />
            <Prompt text="config('pay.wechat.mch_public_cert_path')" />
          </div>
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
          <Prompt text="config('pay.wechat.notify_url')" />
        </div>
      </el-form-item>

      <el-form-item label="公众号app id">
        <el-input v-model="pay.mp_app_id" />
        <div>
          <Prompt text="在 mp.weixin.qq.com 设置与开发->基本配置->开发者ID(AppID) 查看" />
          <Prompt text="config('pay.wechat.mp_app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="小程序app id">
        <el-input v-model="pay.mini_app_id" />
        <div>
          <Prompt text="config('pay.wechat.mini_app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="app id">
        <el-input v-model="pay.app_id" />
        <div>
          <Prompt text="config('pay.wechat.app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="子公众号 app id" v-if="pay.mode">
        <el-input v-model="pay.sub_mp_app_id" />
        <div>
          <Prompt text="服务商模式下，子公众号 的 app_id" />
          <Prompt text="config('pay.wechat.sub_mp_app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="子app app_id" v-if="pay.mode">
        <el-input v-model="pay.sub_app_id" />
        <div>
          <Prompt text="服务商模式下，子app 的 app_id" />
          <Prompt text="config('pay.wechat.sub_app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="子小程序 app id" v-if="pay.mode">
        <el-input v-model="pay.sub_mini_app_id" />
        <div>
          <Prompt text="服务商模式下，子小程序 的 app_id" />
          <Prompt text="config('pay.wechat.sub_mini_app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="子商户id" v-if="pay.mode">
        <el-input v-model="pay.sub_mch_id" />
        <div>
          <Prompt text="服务商模式下，子商户id" />
          <Prompt text="config('pay.wechat.sub_mch_id')" />
        </div>
      </el-form-item>

      <el-form-item label="验签支付序列号">
        <el-input v-model="pay.pay_serial_number" />
        <Prompt text="平台证书模式验签使用该配置 文档: https://pay.weixin.qq.com/doc/v3/merchant/4013053249" />
        <Prompt text="config('pay.wechat.pay_serial_number')" />
      </el-form-item>
      <el-form-item label="验签支付序列号证书" v-if="pay.pay_serial_number" :rules="[{ required: true, message: '请设置验签支付序列号证书' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.public_key_pem_path" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/wechat" />
          <Prompt text="config('pay.wechat.public_key_pem_path')" />
        </div>
      </el-form-item>

      <el-form-item label="微信支付公钥ID">
        <el-input v-model="pay.public_cert_id" />
        <Prompt text="微信支付公钥验签使用该配置 文档: https://pay.weixin.qq.com/doc/v3/merchant/4013053249" />
        <Prompt text="config('pay.wechat.public_cert_id')" />
      </el-form-item>
      <el-form-item label="微信支付公钥ID证书" v-if="pay.public_cert_id" :rules="[{ required: true, message: '请设置验签支付序列号证书' }]">
        <div class="flex flex-col">
          <UploadFile v-model="pay.public_key_pem_path" :file-extensions="['.pem', '.cert']" disk="certs" path="pay/wechat" />
          <Prompt text="config('pay.wechat.public_key_pem_path')" />
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
interface Wechat {
  mch_id: string // 必填-商户号，服务商模式下为服务商商户号 可在 https://pay.weixin.qq.com/ 账户中心->商户信息 查看
  mch_secret_key_v2: string // 选填-v2商户私钥
  mch_secret_key: string // 必填-v3 商户秘钥 即 API v3 密钥(32字节，形如md5值)，可在 账户中心->API安全 中设置
  mch_secret_cert: string // 必填-商户私钥 即 API证书 PRIVATE KEY，可在 账户中心->API安全->申请API证书 里获得 文件名形如：apiclient_key.pem
  mch_public_cert_path: string // 必填-商户公钥证书路径 即 API证书 CERTIFICATE，可在 账户中心->API安全->申请API证书 里获得 文件名形如：apiclient_cert.pem
  notify_url: string // 必填-微信回调url  不能有参数，如?号，空格等，否则会无法正确回调
  mp_app_id: string // 选填-公众号 的 app_id 可在 mp.weixin.qq.com 设置与开发->基本配置->开发者ID(AppID) 查看
  mini_app_id: string // 选填-小程序 的 app_id
  app_id: string // 选填-app 的 app_id
  sub_mp_app_id: string // 选填-服务商模式下，子公众号 的 app_id
  sub_app_id: string // 选填-服务商模式下，子 app 的 app_id
  sub_mini_app_id: string // 选填-服务商模式下，子小程序 的 app_id
  sub_mch_id: string // 选填-服务商模式下，子商户id
  mode: number
  pay_serial_number: string // 选填-验签支付序列号
  public_cert_id: string // 选填-微信支付公钥ID
  public_key_pem_path: string // 选填-微信支付公钥ID证书
  public_cert_path: string // 选填-微信支付公钥证书路径
}

const pay = ref<Wechat>({
  mode: 0,
  mch_id: '',
  mch_secret_key_v2: '',
  mch_secret_key: '',
  mch_secret_cert: '',
  mch_public_cert_path: '',
  notify_url: '',
  mp_app_id: '',
  mini_app_id: '',
  app_id: '',
  sub_mp_app_id: '',
  sub_app_id: '',
  sub_mini_app_id: '',
  sub_mch_id: '',
  pay_serial_number: '',
  public_cert_id: '',
  public_key_pem_path: '',
  public_cert_path: ''
})

const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('pay/config', { wechat: pay.value }).then(r => {
        Message.success('微信支付配置成功')
      })
    }
  })
}

http.get('pay/config/wechat').then(r => {
  Object.assign(pay.value, r.data.data)
})
</script>
