<template>
  <div class="z-20 flex flex-row w-full border-b border-l border-gray-200 dark:border-gray-800 h-14" style="background-color: var(--header-bg-color)">
    <div class="flex flex-row justify-between w-full h-14">
      <div class="flex flex-row min-w-[17rem]">
        <div class="flex items-center w-8 h-full ml-2 hover:cursor-pointer" @click="store.changeExpaned">
          <Icon name="list-bullet" class="w-6 h-8" />
        </div>
        <div class="flex items-center pl-3 w-96 sm:pl-0">
          <Breadcrumbs v-show="!store.getVertical" />
          <TopMenu v-show="store.getVertical" />
        </div>
      </div>

      <div class="grid grid-cols-3 sm:grid-cols-5 w-72 sm:min-w-[16rem] pl-1 sm:pl-0">
        <!-- 搜索 -->
        <MenuSearch />
        <!-- 多语言 -->
        <Lang />
        <!-- 暗黑主题 -->
        <Theme />
        <Notification />
        <Profile />
      </div>
    </div>
  </div>
  <Tabs />
</template>
<script setup lang="ts">
import { useAppStore } from '@/stores/modules/app'
import Notification from './notification.vue'
import MenuSearch from './menuSearch.vue'
import Tabs from './tabs.vue'
import TopMenu from './topMenu.vue'
const store = useAppStore()
</script>
