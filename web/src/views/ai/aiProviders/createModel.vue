<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="模型ID" prop="name" :rules="[{ required: true, message: '请输入模型ID' }]">
      <el-input v-model="formData.name" clearable placeholder="请输入模型ID" />
    </el-form-item>
    <el-form-item label="模型显示名称" prop="display_name" :rules="[{ required: true, message: '请输入模型显示名称' }]">
      <el-input v-model="formData.display_name" clearable placeholder="请输入模型显示名称" />
    </el-form-item>
    <el-form-item label="最大token数" prop="max_token" :rules="[{ required: true, message: '请输入最大token数' }]">
      <el-input-number v-model="formData.max_token" :min="1" :max="2048">
        <template #suffix>
          <span>K</span>
        </template>
      </el-input-number>
    </el-form-item>
    <el-form-item label="支持图像" prop="is_support_image">
      <el-switch v-model="formData.is_support_image" inline-prompt :active-icon="Check" :inactive-icon="Close" :inactive-value="2" :active-value="1" />
    </el-form-item>
    <el-form-item label="是否启用" prop="status">
      <el-switch v-model="formData.status" :inactive-value="2" :active-value="1" />
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
import { Check, Close } from '@element-plus/icons-vue'
import { inject, onMounted } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String,
  providerId: [Number, String]
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)

formData.value.max_token = 32
formData.value.is_support_image = 2
formData.value.provider_id = props.providerId
formData.value.status = 1
if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const emits = defineEmits(['close'])
onMounted(() => {
  close(() => emits('close'))
})
</script>
