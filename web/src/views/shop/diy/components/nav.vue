<template>
  <div
    :class="'p-2 gap-2 grid grid-cols-' + nav.style.cols"
    :style="`background-color:${nav.style.background_color};padding-left:${nav.style.pl}px;padding-top:${nav.style.pt}px;padding-right:${nav.style.pr}px;padding-buttom:${nav.style.pb}px`"
  >
    <div class="flex flex-col" v-for="(item, key) in nav.data" :key="key">
      <div class="flex justify-center">
        <el-image :src="item.icon" :class="'h-10 w-10 ' + (nav.style.shape === 'circle' ? 'rounded-full' : '')">
          <template #error>
            <div class="flex justify-center items-center">
              <el-icon><icon-picture /></el-icon>
            </div>
          </template>
        </el-image>
      </div>
      <div class="text-xs text-center mt-3 text-gray-600" :style="'color:' + nav.style.color">{{ item.title }}</div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Picture as IconPicture } from '@element-plus/icons-vue'

import { NavComponent } from '../component'
const nav = defineModel<NavComponent>({ required: true })
</script>
<style scoped></style>
