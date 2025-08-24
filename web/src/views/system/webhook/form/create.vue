<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="平台"
      prop="platform"
      :rules="[
        {
          required: true,
          message: '请选择平台'
        }
      ]"
    >
      <el-select v-model="formData.platform" placeholder="请选择平台" clearable class="w-full">
        <el-option v-for="item in platforms" :key="item.value" :label="item.label" :value="item.value" />
      </el-select>
    </el-form-item>
    <el-form-item
      label="webhook"
      prop="webhook"
      :rules="[
        {
          required: true,
          message: '请填写选择平台的 webhook 地址'
        }
      ]"
    >
      <el-input v-model="formData.webhook" name="webhook" clearable placeholder="填写平台的 webhook 地址" />
    </el-form-item>
    <el-form-item
      label="推送事件"
      prop="event"
      :rules="[
        {
          required: true,
          message: '请选择推送的事件'
        }
      ]"
    >
      <Select v-model="formData.event" name="event" clearable placeholder="请选择推送的事件" api="webhookEvents" />
    </el-form-item>
    <el-form-item label="签名密钥" prop="secret" v-if="formData.platform !== 3">
      <el-input v-model="formData.secret" name="secret" placeholder="填写 webhook 消息签名密钥" />
    </el-form-item>
    <el-form-item label="消息格式" prop="msg_type">
      <el-radio-group v-model="formData.msg_type">
        <el-radio label="text"> 文本 </el-radio>
        <el-radio label="markdown" v-if="formData.platform !== 2"> markdown </el-radio>
      </el-radio-group>
    </el-form-item>
    <el-form-item
      label="消息内容"
      prop="content"
      :rules="[
        {
          required: true,
          message: '请填写消息内容'
        }
      ]"
    >
      <el-input v-model="formData.content" name="content" placeholder="填写消息内容" type="textarea" rows="10" />
      <div class="text-sm text-gray-400">
        消息内容支持文本和markdown格式,同时也支持变量，变量请使用【<span class="text-red-600">{}</span>】包裹，例如 <span class="text-red-600">{content}</span> ，<span class="text-red-600"
          >{name}</span
        >
        格式
      </div>
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

const platforms = [
  {
    value: 1,
    label: '钉钉'
  },
  {
    value: 2,
    label: '飞书'
  },
  {
    value: 3,
    label: '企微'
  }
]
const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)
formData.value.msg_type = 'text' // 默认文本消息
if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
