<template>
  <div class="grid items-center h-10 grid-cols-5 gap-x-1" :style="style">
    <div v-for="(item, key) in categories" :key="key" class="text-sm text-center text-white" :style="fontColor">{{ item }}</div>
  </div>
</template>
<script lang="ts" setup>
import { CategoryComponent } from '../component'
import { computed } from 'vue'
const category = defineModel<CategoryComponent>({ required: true })
const categories = ['精选', '精品女装', '母婴', '男装', '运动']

const fontColor = computed(() => {
  return `color:${category.value.style.color}`
})
const style = computed(() => {
  return ` background: linear-gradient(to right,${category.value.style.background_color_start}, ${category.value.style.background_color_end});padding:${category.value.style.pt}px ${category.value.style.pr}px ${category.value.style.pb}px ${category.value.style.pl}px`
})
</script>
