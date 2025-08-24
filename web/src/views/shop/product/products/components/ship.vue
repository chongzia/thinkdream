<template>
  <el-form :model="ship" label-width="130px" ref="form" class="w-1/3 min-h-[60rem]">
    <el-form-item label="运费类型" prop="type" class="gap-4">
      <el-radio-group v-model="ship.ship_type">
        <el-radio :value="1" size="large" border>固定运费</el-radio>
        <el-radio :value="2" size="large" border>运费模版</el-radio>
      </el-radio-group>
    </el-form-item>
    <el-form-item label="邮费" prop="keywords" v-if="ship.ship_type === 1">
      <el-input-number v-model="ship.ship_fee" name="ship_fee" clearable size="large" />
    </el-form-item>
    <el-form-item label="运费模版" prop="subtitle" v-else>
      <el-select v-model="ship.ship_template_id" placeholder="请选择运费模版" class="w-2/3" clearable>
        <el-option v-for="template in templates" :key="template.id" :label="template.title" :value="template.id" />
      </el-select>
    </el-form-item>
  </el-form>
</template>
<script lang="ts" setup>
// @ts-nocheck
import { useProductStore } from '../store'
import { reactive, ref } from 'vue'
import { useFormSubmit } from './useFormSubmit'
import http from '@/support/http'

const productStore = useProductStore()
const props = defineProps({
  next: {
    type: Function,
    default: null
  }
})
const ship = reactive(productStore.getShip)
const templates = ref([])
http.get('shop/ship/template', { limit: 10000 }).then(r => {
  templates.value = r.data.data
})
const { form, submit } = useFormSubmit(props.next)
defineExpose({ submit })
</script>
