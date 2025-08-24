<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item label="订单号">
      <div class="flex flex-col">
        <div>{{ order_no }}</div>
        <Prompt text="需要退款的订单号" />
      </div>
    </el-form-item>
    <el-form-item label="退款金额" prop="refund_amount" :rules="[{ required: true, message: '退款金额必须填写' }]">
      <div class="flex flex-col w-full">
        <el-input-number v-model="formData.refund_amount" :step="0.01" size="large" :min="0" :max="order_amount" />
        <Prompt :text="`订单退款金额，订单最大金额${order_amount}元`" />
      </div>
    </el-form-item>

    <el-form-item label="退款原因" prop="reason" :rules="[{ required: true, message: '请填写退款原因' }]">
      <el-input v-model="formData.reason" />
      <Prompt text="订单退款原因" />
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
  order_id: {
    type: Number,
    required: true
  },
  order_no: {
    type: String,
    required: true
  },
  order_amount: {
    type: Number,
    required: true
  }
})

const { formData, form, loading, submitForm, close } = useCreate(`/pay/order/${props.order_id}/refund`)

const emits = defineEmits(['closeRefund'])
onMounted(() => {
  close(() => emits('closeRefund'))
})
</script>
