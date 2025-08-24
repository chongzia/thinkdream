<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="订单号">
      <div class="flex flex-col">
        <div>{{ order_no }}</div>
      </div>
    </el-form-item>
    <el-form-item label="订单退款号">
      <div class="flex flex-col">
        <div>{{ refund_no }}</div>
      </div>
    </el-form-item>
    <el-form-item label="退款金额">
      <div class="flex flex-col">
        <div>{{ refund_amount }} 元</div>
      </div>
    </el-form-item>
    <el-form-item label="是否同意" prop="is_agree" :rules="[{ required: true, message: '退款金额必须填写' }]">
      <el-radio-group v-model="formData.is_agree">
        <el-radio :value="1">同意</el-radio>
        <el-radio :value="0">拒绝</el-radio>
      </el-radio-group>
    </el-form-item>

    <el-form-item label="拒绝原因" prop="refuse_reason" :rules="[{ required: true, message: '请填写退款拒绝原因' }]" v-if="formData.is_agree === 0">
      <el-input v-model="formData.refuse_reason" />
      <Prompt text="退款拒绝原因" />
    </el-form-item>
    <div class="flex justify-center mt-2">
      <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
    </div>
  </el-form>
</template>
<script lang="ts" setup>
// @ts-nocheck
import { useCreate } from '@/composables/curd/useCreate'
import { inject, onMounted } from 'vue'

const props = defineProps({
  refund_id: {
    type: Number,
    required: true
  },
  order_no: {
    type: String,
    required: true
  },
  refund_no: {
    type: String,
    required: true
  },
  refund_amount: {
    type: Number,
    required: true
  }
})

const { formData, form, loading, submitForm, close } = useCreate(`/pay/order/refund/${props.refund_id}/agree`)
formData.value.is_agree = 1

const emits = defineEmits(['closeAgree'])
onMounted(() => {
  close(() => emits('closeAgree'))
})
</script>
