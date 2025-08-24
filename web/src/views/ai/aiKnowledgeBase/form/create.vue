<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="知识库名称" prop="title" :rules="[{ required: true, message: '请输入知识库标题' }]">
      <el-input v-model="formData.title" name="title" clearable placeholder="请输入知识库名称" />
    </el-form-item>
    <el-form-item label="知识库描述" prop="description" :rules="[{ required: true, message: '请输入知识库描述' }]">
      <el-input v-model="formData.description" name="description" clearable type="textarea" rows="5" placeholder="请输入知识库描述" />
    </el-form-item>
    <el-form-item label="向量模型" prop="embedding_model" :rules="[{ required: true, message: '请选择知识库向量模型' }]">
      <Select v-model="formData.embedding_model" name="embedding_model" clearable api="embeddingModels" placeholder="请选择知识库向量模型" />
    </el-form-item>
    <el-form-item label="知识库排序" prop="sort">
      <el-input-number v-model="formData.sort" name="sort" :min="1" />
    </el-form-item>
    <el-form-item label="状态" prop="status">
      <el-radio-group v-model="formData.status">
        <el-radio
          v-for="item in [
            { label: '启用', value: 1 },
            { label: '禁用', value: 2 }
          ]"
          :key="item.value"
          :value="item.value"
          name="status"
          >{{ item.label }}</el-radio
        >
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
formData.value.sort = 1
formData.value.status = 1

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
