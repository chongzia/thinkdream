<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="知识库ID" prop="knowledge_id">
      <el-select v-model="formData.knowledge_id" placeholder="请选择" clearable>
        <el-option v-for="item in { options }" :key="item.value" :label="item.label" :value="item.value" />
      </el-select>
    </el-form-item>
    <el-form-item label="文件名称" prop="filename">
      <el-input v-model="formData.filename" name="filename" clearable />
    </el-form-item>
    <el-form-item label="文档后缀" prop="extension">
      <el-input v-model="formData.extension" name="extension" clearable />
    </el-form-item>
    <el-form-item label="文件内容" prop="content">
      <el-input v-model="formData.content" name="content" type="textarea" clearable />
    </el-form-item>
    <el-form-item label="向量内容" prop="embedding_content">
      <el-input v-model="formData.embedding_content" name="embedding_content" type="textarea" clearable />
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
