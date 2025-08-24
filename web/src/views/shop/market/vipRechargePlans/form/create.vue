<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="套餐名称" prop="title" :rules="[{ required: true, message: '套餐名称必须填写' }]">
      <el-input v-model="formData.title" name="title" clearable placeholder="请输入套餐名称" />
    </el-form-item>
    <el-form-item label="充值金额" prop="price" :rules="[{ required: true, message: '充值金额必须填写' }]">
      <div class="flex flex-col">
        <div><el-input-number v-model="formData.price" name="price" :min="1" controls-position="right" /> <span>元</span></div>
        <Prompt text="会员实际充值金额" />
      </div>
    </el-form-item>
    <el-form-item label="赠送金额" prop="handsel_price" :rules="[{ required: true, message: '赠送金额必须填写' }]">
      <div class="flex flex-col">
        <div><el-input-number v-model="formData.handsel_price" name="handsel_price" :min="0" controls-position="right" /><span>元</span></div>
        <Prompt text="会员实际充值后赠送金额, 赠送金额应小于充值金额" />
      </div>
    </el-form-item>
    <el-form-item label="排序" prop="sort" :rules="[{ required: true }]">
      <div class="flex flex-col">
        <el-input-number v-model="formData.sort" name="sort" :min="1" controls-position="right" />
        <Prompt text="倒序排列" />
      </div>
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
if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
