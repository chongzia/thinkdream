<template>
  <el-form :model="basic" label-width="130px" ref="form" class="w-1/3 min-h-[60rem]">
    <el-form-item label="商品类型" prop="type" class="gap-4">
      <div class="flex gap-4">
        <div
          v-for="productType in productTypes"
          :key="productType.value"
          :class="'border w-36 h-36  rounded-lg leading-10 flex flex-col items-center justify-center cursor-pointer ' + (productType.value === basic.type ? ' border-indigo-600' : 'border-gray-100')"
          @click="basic.type = productType.value"
        >
          <div v-if="productType.value === basic.type" class="text-lg text-indigo-600">{{ productType.label }}</div>
          <div v-else>{{ productType.label }}</div>
          <div>{{ productType.subtitle }}</div>
        </div>
      </div>
    </el-form-item>
    <el-form-item
      label="商品名称"
      prop="title"
      :rules="[
        {
          required: true,
          message: '商品名称必须填写'
        }
      ]"
    >
      <el-input v-model="basic.title" name="title" clearable placeholder="请输入商品名称" size="large" />
    </el-form-item>
    <el-form-item label="关键字" prop="keywords">
      <el-input v-model="basic.keywords" name="keywords" clearable placeholder="请输入关键字" size="large" />
    </el-form-item>
    <el-form-item label="商品描述" prop="subtitle">
      <el-input v-model="basic.subtitle" name="subtitle" clearable type="textarea" placeholder="请输入商品描述" size="large" />
    </el-form-item>
    <el-form-item
      label="商品主图"
      prop="images"
      :rules="[
        {
          required: true,
          message: '商品主图必须上传'
        }
      ]"
    >
      <AttachUpload v-model="basic.images" name="images" :multi="true" />
    </el-form-item>
    <el-form-item label="商品视频" prop="video">
      <Upload v-model="basic.video" name="images" />
    </el-form-item>
    <el-form-item label="商品品牌" prop="brand">
      <Select api="brand" v-model="basic.brand_id" name="brand" placeholder="请选择商品品牌" size="large" />
    </el-form-item>
    <el-form-item
      label="商品分类"
      prop="category_ids"
      :rules="[
        {
          required: true,
          message: '商品分类必须选择'
        }
      ]"
    >
      <Cascade v-model="basic.category_ids" placeholder="请选择商品分类" clearable multiple api="shop/category" size="large" />
    </el-form-item>
    <el-form-item label="商品单位" prop="unit" class="">
      <el-input v-model="basic.unit" placeholder="请输入商品单位" size="large" />
    </el-form-item>
    <el-form-item label="虚拟销量" prop="virtual_sales">
      <el-input-number v-model="basic.virtual_sales" :min="1" controls-position="right" size="large" />
    </el-form-item>
    <el-form-item label="商品排序" prop="sort">
      <el-input-number v-model="basic.sort" :min="1" controls-position="right" size="large" />
    </el-form-item>
    <el-form-item label="是否上架" prop="is_available">
      <el-radio-group v-model="basic.is_available">
        <el-radio
          v-for="item in [
            { label: '立即上架', value: 1 },
            { label: '放入仓库', value: 2 }
          ]"
          :key="item.value"
          :value="item.value"
          name="is_available"
          >{{ item.label }}</el-radio
        >
      </el-radio-group>
    </el-form-item>
    <el-form-item label="定时上架" prop="is_schedule">
      <el-radio-group v-model="basic.is_schedule">
        <el-radio
          v-for="item in [
            { label: '启用', value: 1 },
            { label: '不启用', value: 2 }
          ]"
          :key="item.value"
          :value="item.value"
          name="is_schedule"
          >{{ item.label }}</el-radio
        >
      </el-radio-group>
    </el-form-item>
    <el-form-item label="上架时间" prop="schedule_time" v-if="basic.is_schedule === 1">
      <el-date-picker v-model="basic.schedule_time" type="datetime" placeholder="请选择上架时间" format="YYYY/MM/DD HH:mm:ss" size="large" value-format="YYYY-MM-DD HH:mm:ss" />
    </el-form-item>
  </el-form>
</template>

<script lang="ts" setup>
// 商品基本信息
import { useProductStore } from '../store'
import { reactive } from 'vue'
import { useFormSubmit } from './useFormSubmit'
const productStore = useProductStore()

const basic = reactive(productStore.getBasic)
const props = defineProps({
  next: {
    type: Function,
    default: null
  }
})
const productTypes = [
  {
    label: '实物商品',
    value: 1,
    subtitle: '(需要物流)'
  },
  {
    label: '卡密商品',
    value: 2,
    subtitle: '(无需物流)'
  },
  {
    label: '虚拟商品',
    value: 3,
    subtitle: '(无需物流)'
  }
]

const { form, submit } = useFormSubmit(props.next)
defineExpose({ submit })
</script>
