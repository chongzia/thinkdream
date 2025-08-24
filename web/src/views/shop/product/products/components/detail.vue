<template>
  <div class="min-h-[60rem]">
    <el-form :model="info" label-width="130px" ref="form">
      <el-form-item label="商品详情" prop="content">
        <editor :height="500" v-model="info.content" />
        <el-input v-model="info.content" class="invisible" />
      </el-form-item>
    </el-form>
  </div>
</template>
<script lang="ts" setup>
// 商品基本信息
import { useProductStore } from '../store'
import { reactive } from 'vue'
import { useFormSubmit } from './useFormSubmit'

const productStore = useProductStore()
const props = defineProps({
  next: {
    type: Function,
    default: null
  }
})
const info = reactive(productStore.getInfo)
const { form, submit } = useFormSubmit(props.next)
defineExpose({ submit })
</script>
