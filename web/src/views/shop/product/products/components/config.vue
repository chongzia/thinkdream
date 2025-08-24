<template>
  <el-form :model="config" label-width="170px" ref="form" class="min-h-[60rem]">
    <el-form-item label="是否展示划线价" prop="is_show_list_price">
      <el-switch v-model="config.is_show_list_price" :active-value="1" :inactive-value="2" />
    </el-form-item>
    <el-form-item label="是否展示虚拟销量" prop="is_show_virtual_sales">
      <el-switch v-model="config.is_show_virtual_sales" :active-value="1" :inactive-value="2" />
    </el-form-item>
    <el-form-item label="是否展示成本价" prop="is_show_cost_price">
      <el-switch v-model="config.is_show_cost_price" :active-value="1" :inactive-value="2" />
    </el-form-item>
    <el-form-item label="商品参数" prop="params">
      <div>
        <el-button type="primary" @click="addParmas">添加参数</el-button>
        <div class="flex flex-col">
          <div v-for="(param, key) in config.params" :key="key" class="flex gap-3 mt-3">
            <div><el-input v-model="param.key" placeholder="请输入参数名" /></div>
            <div><el-input v-model="param.value" placeholder="请输入参数值" /></div>
            <div><Icon name="trash" className="w-5 h-5 text-red-600 mt-2" @click="delParams(key)" /></div>
          </div>
        </div>
      </div>
    </el-form-item>
  </el-form>
</template>
<script lang="ts" setup>
// @ts-nocheck
import { useProductStore } from '../store'
import { reactive } from 'vue'
import { useFormSubmit } from './useFormSubmit'

const productStore = useProductStore()

const config = reactive(productStore.getConfig)
const props = defineProps({
  next: {
    type: Function,
    default: null
  }
})
const addParmas = () => {
  config.params.push({
    key: '',
    value: ''
  })
}
const delParams = (k: number) => {
  config.params = config.params.filter((item, key) => {
    return k !== key
  })
}
const { form, submit } = useFormSubmit(props.next)
defineExpose({ submit })
</script>
