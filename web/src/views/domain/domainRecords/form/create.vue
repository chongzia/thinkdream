<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="记录类型"
      prop="type"
      :rules="[
        {
          required: true,
          message: '记录类型必须填写'
        }
      ]"
    >
      <Select api="recordTypes" v-model="formData.type" clearable class="w-full" filterable />
    </el-form-item>
    <el-form-item
      label="主机记录"
      prop="name"
      :rules="[
        {
          required: true,
          message: '主机记录必须填写'
        }
      ]"
    >
      <div class="flex">
        <el-input v-model="formData.name" name="name" clearable placeholder="请输入主机记录" />
        <div class="ml-1">.{{ domain }}</div>
      </div>
      <div class="pt-3 text-sm text-gray-300">主机记录即域名前缀, 例如 www, test 等等</div>
    </el-form-item>
    <el-form-item
      label="记录值"
      prop="value"
      :rules="[
        {
          required: true,
          message: '记录类型必须填写'
        }
      ]"
    >
      <el-input v-model="formData.value" name="value" clearable placeholder="请输入记录值，一般为服务器ip地址" />
    </el-form-item>
    <el-form-item
      label="TTL"
      prop="ttl"
      :rules="[
        {
          required: true,
          message: '请选择 TTL 时间'
        }
      ]"
    >
      <el-input-number v-model="formData.ttl" name="ttl" clearable placeholder="请输入ttl记录值" :min="600" />
      <div class="pt-3 text-sm text-gray-300">解析在 DNS 缓存的时间，最小 10 分钟</div>
    </el-form-item>
    <el-form-item label="备注" prop="remark">
      <el-input v-model="formData.remark" name="remark" clearable type="textarea" placeholder="填写域名备注" />
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
  api: String,
  domain: String,
  domainId: Number
})

const { formData, form, loading, submitForm, close, beforeUpdate, beforeCreate } = useCreate(props.api as string, props.primary)
formData.value.ttl = 600
beforeUpdate.value = () => {
  formData.value.domain = props.domain
  formData.value.id = props.domainId
}

beforeCreate.value = () => {
  formData.value.domain = props.domain
  formData.value.id = props.domainId
}
if (props.primary) {
  useShow(props.api as string, props.primary + `?domain=${props.domain}&id=${props.domainId}`, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
