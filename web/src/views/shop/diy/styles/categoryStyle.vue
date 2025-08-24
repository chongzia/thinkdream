<template>
  <div>
    <div class="flex items-center h-10 pl-5 pr-5 text-base border-b border-gray-200">{{ category.title }}</div>
    <div class="flex flex-col p-5">
      <el-form-item label="文字颜色">
        <el-color-picker v-model="category.style.color" size="small" />
      </el-form-item>
      <el-form-item label="背景渐变色">
        <el-color-picker v-model="category.style.background_color_start" size="small" />
        <el-color-picker v-model="category.style.background_color_end" size="small" />
      </el-form-item>
      <el-form-item label="上边距">
        <div class="grid w-full grid-cols-4 gap-x-4">
          <el-slider v-model="category.style.pt" size="small" class="col-span-3" />
          <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ category.style.pt }}</div>
        </div>
      </el-form-item>
      <el-form-item label="下边距">
        <div class="grid w-full grid-cols-4 gap-x-4">
          <el-slider v-model="category.style.pb" size="small" class="col-span-3" />
          <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ category.style.pb }}</div>
        </div>
      </el-form-item>
      <el-form-item label="左边距">
        <div class="grid w-full grid-cols-4 gap-x-4">
          <el-slider v-model="category.style.pl" size="small" class="col-span-3" />
          <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ category.style.pl }}</div>
        </div>
      </el-form-item>
      <el-form-item label="右边距">
        <div class="grid w-full grid-cols-4 gap-x-4">
          <el-slider v-model="category.style.pr" size="small" class="col-span-3" />
          <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ category.style.pr }}</div>
        </div>
      </el-form-item>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { CategoryComponent } from '../component'

const category = defineModel<CategoryComponent>({ required: true })
</script>
