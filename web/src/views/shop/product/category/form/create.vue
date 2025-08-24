<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="父级分类" prop="parent_id">
      <treeSelectParent :api="api" v-model="formData.parent_id" />
    </el-form-item>
    <el-form-item
      label="分类名称"
      prop="name"
      :rules="[
        {
          required: true,
          message: '分类名称必须填写'
        }
      ]"
    >
      <el-input v-model="formData.name" name="name" clearable />
    </el-form-item>
    <el-form-item label="分类图标" prop="icon">
      <AttachUpload v-model="formData.icon" name="images" :multi="false" image-class="w-28 h-28" />
    </el-form-item>
    <el-form-item label="排序" prop="sort">
      <el-input-number v-model="formData.sort" name="sort" :min="1" />
    </el-form-item>
    <el-form-item label="状态" prop="status">
      <el-radio-group v-model="formData.status">
        <el-radio v-for="item in status" :key="item.value" :value="item.value" name="status">{{ item.label }}</el-radio>
      </el-radio-group>
    </el-form-item>
    <el-form-item label="seo标题" prop="title">
      <el-input v-model="formData.title" name="title" clearable />
    </el-form-item>
    <el-form-item label="seo关键字" prop="keywords">
      <el-input v-model="formData.keywords" name="keywords" clearable />
    </el-form-item>
    <el-form-item label="seo描述" prop="descriptions">
      <el-input v-model="formData.descriptions" name="descriptions" clearable />
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
import { status } from '@/support/options'

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
