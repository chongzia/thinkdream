<template>
  <div class="flex flex-col justify-center w-full bg-white item-center dark:bg-regal-dark">
    <el-form :model="pay" label-width="200px" ref="form" class="w-full mt-10 mb-10 md:w-1/2" v-loading="loading">
      <div class="flex justify-center w-full mb-5 text-lg text-gray-600">抖音支付配置</div>

      <el-form-item label="商户号" prop="mch_id" :rules="[{ required: true, message: '商户号必须填写' }]">
        <el-input v-model="pay.mch_id" />
        <div>
          <Prompt text="抖音开放平台 --> 应用详情 --> 支付信息 --> 产品管理 --> 商户号" />
          <Prompt text="config('pay.douyin.mch_id')" />
        </div>
      </el-form-item>

      <el-form-item label="支付 Token" prop="mch_secret_token" :rules="[{ required: true, message: '请设置支付 Token' }]">
        <el-input v-model="pay.mch_secret_token" />
        <div>
          <Prompt text="用于支付回调签名, 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> Token(令牌)" />
          <Prompt text="config('pay.douyin.mch_secret_token')" />
        </div>
      </el-form-item>

      <el-form-item label="支付 SALT" prop="mch_secret_salt" :rules="[{ required: true, message: '请设置支付 SALT' }]">
        <el-input v-model="pay.mch_secret_salt" />
        <div>
          <Prompt text="用于支付签名, 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> SALT" />
          <Prompt text="config('pay.douyin.mch_secret_salt')" />
        </div>
      </el-form-item>

      <el-form-item label="小程序 app_id" prop="mini_app_id" :rules="[{ required: true, message: '请设置小程序 app_id' }]">
        <el-input v-model="pay.mini_app_id" />
        <div>
          <Prompt text="抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> 小程序appid" />
          <Prompt text="config('pay.douyin.mini_app_id')" />
        </div>
      </el-form-item>

      <el-form-item label="抖音开放平台服务商id  " prop="thirdparty_id" :rules="[{ required: true, message: '请设置抖音开放平台服务商id' }]">
        <el-input v-model="pay.thirdparty_id" />
        <div>
          <Prompt text="设置抖音开放平台服务商id" />
          <Prompt text="config('pay.douyin.thirdparty_id')" />
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
          <Prompt text="config('pay.douyin.notify_url')" />
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
interface Douyinpay {
  mch_id: string // 选填-商户号 抖音开放平台 --> 应用详情 --> 支付信息 --> 产品管理 --> 商户号
  mch_secret_token: string // 必填-支付 Token，用于支付回调签名 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> Token(令牌)
  mch_secret_salt: string // 必填-支付 SALT，用于支付签名 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> SALT
  mini_app_id: string // 必填-小程序 app_id 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> 小程序appid
  thirdparty_id: string // 选填-抖音开放平台服务商id
  notify_url: string // 选填-抖音支付回调地址
}

const pay = ref<Douyinpay>({
  mch_id: '',
  mch_secret_token: '',
  mch_secret_salt: '',
  mini_app_id: '',
  thirdparty_id: '',
  notify_url: ''
})

const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('pay/config', { douyin: pay.value }).then(r => {
        Message.success('抖音支付配置成功')
      })
    }
  })
}

http.get('pay/config/douyin').then(r => {
  Object.assign(pay.value, r.data.data)
})
</script>
