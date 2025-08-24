<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="域名"
      prop="name"
      :rules="[
        {
          required: true,
          message: '域名必须填写'
        }
      ]"
    >
      <el-input v-model="formData.name" name="name" clearable />
    </el-form-item>
    <el-form-item
      label="所属域名商"
      prop="type"
      :rules="[
        {
          required: true,
          message: '所属域名商必须选择'
        }
      ]"
    >
      <el-radio-group v-model="formData.type">
        <el-radio value="qcloud">腾讯云</el-radio>
        <el-radio value="aliyun">阿里云</el-radio>
      </el-radio-group>
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
  api: String
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)
formData.value.type = 'qcloud'

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
