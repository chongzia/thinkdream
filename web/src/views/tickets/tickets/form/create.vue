<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="工单编号" prop="ticket_no" >
  <el-input v-model="formData.ticket_no" name="ticket_no" clearable />
</el-form-item>

<el-form-item label="工单标题" prop="title" >
  <el-input v-model="formData.title" name="title" clearable />
</el-form-item>

<el-form-item label="工单内容" prop="content" >
  <el-input v-model="formData.content" name="content" type="textarea" clearable />
</el-form-item>

<el-form-item label="工单状态 (1" prop="status" >
  <el-input-number v-model="formData.status" name="status" :min="1" />
</el-form-item>

<el-form-item label="优先级 (1" prop="priority" >
  <el-input-number v-model="formData.priority" name="priority" :min="1" />
</el-form-item>

<el-form-item label="关联的模板ID" prop="template_id" >
   <RemoteSelect table="ticket_templates" value="id" label="name" v-model="formData.template_id" placeholder="请选择关联的模板ID"/>
</el-form-item>

<el-form-item label="受理人ID" prop="assignee_id" >
   <RemoteSelect table="admin_users" value="id" label="username" v-model="formData.assignee_id" placeholder="请选择受理人ID"/>
</el-form-item>

<el-form-item label="存储根据模板生成的表单数据" prop="form_data" >
  <el-input v-model="formData.form_data" name="form_data" type="textarea" clearable />
</el-form-item>

<el-form-item label="关闭时间" prop="closed_at" >
  <el-date-picker
      v-model="formData.closed_at"
      type="datetime"
      name="closed_at"
      placeholder="选择日期"
      value-format="YYYY-MM-DD"
      clearable
  />
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
formData.status = 1
formData.priority = 1

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
