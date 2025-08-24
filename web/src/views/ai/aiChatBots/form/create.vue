<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="名称" prop="title" :rules="[{ required: true, message: '请输入名称' }]">
      <el-input v-model="formData.title" name="title" clearable placeholder="请输入智能体名称" />
    </el-form-item>
    <el-form-item label="logo" prop="logo" :rules="[{ required: true, message: '请上传智能体logo' }]">
      <Upload v-model="formData.logo" class="w-20 h-20" />
    </el-form-item>
    <el-form-item label="描述" prop="desc" :rules="[{ required: true, message: '请输入描述' }]">
      <el-input v-model="formData.desc" name="desc" clearable type="textarea" :rows="3" placeholder="请输入智能体描述" />
    </el-form-item>
    <el-form-item label="系统提示词" prop="prompt" :rules="[{ required: true, message: '请输入prompt' }]">
      <el-input v-model="formData.prompt" name="prompt" type="textarea" clearable :rows="5" placeholder="请输入智能体系统prompt" />
    </el-form-item>
    <el-form-item label="模型" prop="models" :rules="[{ required: true, message: '请选择模型' }]">
      <Select v-model="formData.models" api="aiModels" :group="true" multiple placeholder="请输入智能体模型" />
    </el-form-item>
    <el-form-item label="使用知识库" prop="models">
      <el-radio-group v-model="formData.is_use_knowledge">
        <el-radio :value="1">是</el-radio>
        <el-radio :value="0">否</el-radio>
      </el-radio-group>
    </el-form-item>
    <el-form-item label="选择知识库" prop="knowledge_id" :rules="[{ required: true, message: '请选择知识库' }]" v-if="formData.is_use_knowledge">
      <Select v-model="formData.knowledge_id" api="aiModels" placeholder="请选择知识库" />
    </el-form-item>
    <el-form-item label="上下文数" prop="contexts" :rules="[{ required: true, message: '请输入上下文数量' }]">
      <el-input-number :min="0" v-model="formData.contexts" name="contexts" />
      <Prompt text="上下文数是指智能体在对话中可以记住的上下文数量，如果为0，表示不记住任何上下文" />
    </el-form-item>
    <el-form-item label="最大token数" prop="max_tokens" :rules="[{ required: true, message: '请输入最大token数' }]">
      <el-input-number v-model="formData.max_tokens" :min="100" />
    </el-form-item>
    <el-form-item label="温度" prop="temperature" :rules="[{ required: true, message: '请输入温度' }]">
      <el-input-number v-model="formData.temperature" step="0.1" :min="0" />
      <Prompt text=" 温度调整概率分布，低值（如 0）使输出更确定，高值（如 1 或更高）使输出更具创意" />
    </el-form-item>
    <el-form-item label="topP" prop="top_p" :rules="[{ required: true, message: '请输入温度' }]">
      <el-input-number v-model="formData.top_p" step="0.1" :min="0" />
      <Prompt text="TopP（Nucleus Sampling）通过设置概率阈值限制词汇选择，低值（如 0.5）使输出更集中，高值（如 0.9）使输出更多样" />
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
formData.value.is_use_knowledge = 0
formData.value.contexts = 5
formData.value.max_tokens = 2000
formData.value.temperature = 0
formData.value.topP = 0.5

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
