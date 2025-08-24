<template>
  <div class="bg-white rounded-md dark:bg-regal-dark">
    <div>
      <el-card shadow="never">
        <template #header>
          <div>
            <span>基础组件</span>
          </div>
        </template>
        <div>
          <VueDraggable class="grid grid-cols-4 gap-4" v-model="basicComponents" :animation="150" ghostClass="ghost" :group="{ name: 'people', pull: 'clone', put: false }">
            <div
              class="flex flex-col items-center justify-center row-span-5 border border-gray-200 rounded cursor-move hover:border hover:border-indigo-600 hover:shadow hover:shadow-indigo-400/50"
              v-for="(component, k) in basicComponents"
              :key="k"
            >
              <div><Icon :name="component.icon" /></div>
              <div class="mt-2 text-xs">{{ component.title }}</div>
            </div>
          </VueDraggable>
        </div>
      </el-card>
    </div>
    <div class="mt-4">
      <el-card shadow="never">
        <template #header>
          <div>
            <span>营销组件</span>
          </div>
        </template>
        <div>
          <!--
          <VueDraggable :sort="false" @clone="clone" class="grid min-h-0 grid-cols-4 gap-4" v-model="basicComponents" animation="150" ghostClass="ghost" group="people">
            <div class="h-20 border border-red-200" v-for="(component, k) in basicComponents" :key="k">{{ component.title }}<component :is="component.comp" /></div>
          </VueDraggable>-->
        </div>
      </el-card>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { VueDraggable } from 'vue-draggable-plus'
import { basicComponents } from '../component'
/**
const basicComponents = [
  { ...swiper, title: '轮播图', icon: 'photo', active: false },
  { ...search, title: '搜索', active: false, icon: 'magnifying-glass' },
  { title: '分类', active: false, name: 'swiper', icon: 'squares-plus' },
  { title: '导航图', active: false, name: 'swiper', icon: 'photo' },
  { title: '公告', active: false, name: 'swiper', icon: 'megaphone' },
  { title: '新闻列表', active: false, name: 'swiper', icon: 'clipboard-document' },
  { title: '商品列表', active: false, name: 'swiper', icon: 'photo' }
] */

const clone = (element: Record<'name' | 'id', string>) => {
  console.log(element)
}
</script>
