<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="服务名称"
      prop="name"
      :rules="[
        {
          required: true,
          message: '服务名称必须填写'
        }
      ]"
    >
      <el-input v-model="formData.name" name="name" clearable />
    </el-form-item>
    <el-form-item label="图标" prop="icon">
      <Upload v-model="formData.icon" />
    </el-form-item>
    <el-form-item label="服务说明" prop="description">
      <el-input v-model="formData.description" name="description" clearable type="textarea" />
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

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
