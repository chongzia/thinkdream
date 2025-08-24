<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="标题"
      prop="title"
      :rules="[
        {
          required: true,
          message: '标题必须填写'
        }
      ]"
    >
      <el-input v-model="formData.title" name="title" clearable />
    </el-form-item>
    <el-form-item
      label="作者"
      prop="author"
      :rules="[
        {
          required: true,
          message: '作者必须填写'
        }
      ]"
    >
      <el-input v-model="formData.author" name="author" clearable />
    </el-form-item>
    <el-form-item
      label="缩略图"
      prop="thumb_media_id"
      :rules="[
        {
          required: true,
          message: '缩略图必须上传'
        }
      ]"
    >
      <Upload v-model="formData.thumb_media_id" class="w-24" />
    </el-form-item>
    <el-form-item label="描述" prop="digest">
      <el-input v-model="formData.digest" name="digest" type="textarea" clearable />
    </el-form-item>
    <el-form-item
      label="内容"
      prop="content"
      :rules="[
        {
          required: true,
          message: '内容必须填写'
        }
      ]"
    >
      <editor :height="500" v-model="formData.content" />
      <el-input v-model="formData.content" class="invisible" />
    </el-form-item>
    <el-form-item label="阅读原文链接" prop="content_source_url">
      <el-input v-model="formData.content_source_url" name="content_source_url" clearable />
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
