<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="任务名称"
      prop="name"
      :rules="[
        {
          required: true,
          message: '请填写任务名称'
        }
      ]"
    >
      <el-input v-model="formData.name" name="name" clearable show-word-limit maxlength="50" />
    </el-form-item>
    <el-form-item
      label="任务命令"
      prop="command"
      :rules="[
        {
          required: true,
          message: '请填写任务命令'
        }
      ]"
    >
      <el-input v-model="formData.command" name="command" clearable show-word-limit maxlength="100" />
    </el-form-item>
    <div class="grid grid-cols-2">
      <el-form-item
        label="任务周期"
        prop="cycle"
        :rules="[
          {
            required: true,
            message: '请选择任务周期'
          }
        ]"
      >
        <Select v-model="formData.cycle" placeholder="请选择" allow-create api="cronCycle" />
      </el-form-item>
      <el-form-item label="运行在某天" prop="days">
        <el-input-number v-model="formData.days" name="days" clearable />
      </el-form-item>
    </div>
    <div class="grid grid-cols-2">
      <el-form-item label="开始时间" prop="start_at">
        <el-time-select v-model="formData.start_at" start="08:30" step="00:15" end="18:30" placeholder="选择" editable />
      </el-form-item>
      <el-form-item label="结束时间" prop="end_at" v-if="formData.start_at">
        <el-time-select v-model="formData.end_at" start="08:30" step="00:15" end="18:30" placeholder="选择" editable />
      </el-form-item>
    </div>
    <div class="grid grid-cols-2">
      <el-form-item label="是否调度" prop="is_schedule">
        <el-radio-group v-model="formData.is_schedule">
          <el-radio :value="1">是</el-radio>
          <el-radio :value="2">否</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="是否重复运行" prop="is_overlapping">
        <el-radio-group v-model="formData.is_overlapping">
          <el-radio :value="1">是</el-radio>
          <el-radio :value="2">否</el-radio>
        </el-radio-group>
      </el-form-item>
    </div>
    <el-form-item label="单台服务器运行" prop="is_on_one_server">
      <el-radio-group v-model="formData.is_on_one_server">
        <el-radio :value="1">是</el-radio>
        <el-radio :value="2">否</el-radio>
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

import { inject, onMounted } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)
// 默认值
formData.value.is_schedule = 1
formData.value.is_overlapping = 2
formData.value.is_on_one_server = 1
formData.value.is_run_background = 2

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
