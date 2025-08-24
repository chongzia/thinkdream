<script setup lang="ts">
import { useNavTabStore } from '@/stores/modules/tabs'
import ContextMenu from './contextMenu.vue'
import { computed } from 'vue'
const navTabStore = useNavTabStore()
const tabs = computed(() => navTabStore.getNavTabs)
</script>

<template>
  <div class="z-10 flex items-center w-full h-10 py-2 bg-white border-l border-gray-200 shadow-md dark:border-x-gray-800 dark:bg-regal-dark sm:px-3 gap-x-2" ref="container" v-if="tabs.length > 0">
    <ContextMenu>
      <el-tag
        class="hover:cursor-pointer"
        v-for="(tag, index) in tabs"
        :key="index"
        :closable="!tag.meta.affix"
        :disable-transitions="false"
        :effect="tag.is_active ? 'dark' : 'plain'"
        @click.prevent="navTabStore.selectTab(tag)"
        @close="navTabStore.removeTab(index)"
      >
        {{ tag.meta.title }}
      </el-tag>
    </ContextMenu>
  </div>
</template>

<style scoped></style>
