<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-alert title="活动正在进行中，无法进行编辑" v-if="formData.is_processing" type="warning" />
    <el-form-item label="活动开始日期" prop="activity_start_date" :rules="[{ required: true, message: '活动开始日期必须选择' }]" class="mt-2">
      <el-date-picker v-model="formData.activity_start_date" type="date" placeholder="请选择活动开始日期" clearable value-format="YYYY-MM-DD" format="YYYY-MM-DD" />
    </el-form-item>
    <el-form-item label="活动结束日期" prop="activity_end_date" :rules="[{ required: true, message: '活动结束日期必须选择' }]">
      <el-date-picker v-model="formData.activity_end_date" type="date" placeholder="请选择活动结束日期" clearable value-format="YYYY-MM-DD" format="YYYY-MM-DD" />
    </el-form-item>
    <el-form-item label="活动场次" prop="activity_events" :rules="[{ required: true, message: '活动场次必须选择' }]">
      <el-checkbox-group v-model="formData.activity_events">
        <el-checkbox :label="item.label" :value="item.value" v-for="item in events" :key="item.value" />
      </el-checkbox-group>
    </el-form-item>
    <el-form-item label="秒杀商品" prop="seckill_product_id" :rules="[{ required: true, message: '秒杀商品必须选择' }]">
      <Select-Remote api="shop/seckill/products" v-model="formData.seckill_product_id" label="product_title" value="id" :multiple="false" placeholder="请选择秒杀商品" />
    </el-form-item>
    <el-form-item label="状态" prop="status">
      <el-radio-group v-model="formData.status">
        <el-radio
          v-for="item in [
            { value: 1, label: '开启' },
            { value: 2, label: '关闭' }
          ]"
          :key="item.value"
          :value="item.value"
          name="status"
          >{{ item.label }}</el-radio
        >
      </el-radio-group>
    </el-form-item>

    <div class="flex justify-end">
      <el-button type="primary" @click="submitForm(form)" :disabled="formData.is_processing">{{ $t('system.confirm') }}</el-button>
    </div>
  </el-form>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { useCreate } from '@/composables/curd/useCreate'
import { useShow } from '@/composables/curd/useShow'
import { inject, onMounted, ref } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)
formData.value.status = 1

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})

interface event {
  label: string
  value: number
}
const events = ref<Array<event>>([])
// 获取活动场次
const getEvents = () => {
  for (let i = 0; i <= 24; i++) {
    events.value.push({
      label: (i < 10 ? '0' + i : i) + ':00',
      value: i
    })
  }
}
getEvents()
</script>
