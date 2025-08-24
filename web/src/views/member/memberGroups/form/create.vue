<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="组名"
      prop="name"
      :rules="[
        {
          required: true,
          message: '组名必须填写'
        }
      ]"
    >
      <el-input v-model="formData.name" name="name" clearable />
    </el-form-item>
    <el-form-item
      label="分组描述"
      prop="description"
      :rules="[
        {
          required: true,
          message: '分组描述必须填写'
        }
      ]"
    >
      <el-input v-model="formData.description" name="description" clearable />
    </el-form-item>
    <el-form-item label="状态" prop="status">
      <el-radio-group v-model="formData.status">
        <el-radio v-for="item in status" :key="item.value" :label="item.value" name="status">{{ item.label }}</el-radio>
      </el-radio-group>
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
import { status } from '@/support/options'
import { inject, onMounted } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)
formData.value.status = 1

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
