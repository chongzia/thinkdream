<template>
  <div class="flex items-center justify-center border-b h-14 logo-bg dark:border-b-gray-800">
    <img v-if="setting.dashboard.logo" :src="warpHost(setting.dashboard.logo)" class="rounded-full h-9 w-9" />
    <img :src="LogPng" class="rounded-full h-9 w-9" v-else />
    <!--这里写应用名称-->
    <div class="pl-3 text-md logo-text" v-if="store.isExpand">{{ setting.dashboard.name }}</div>
  </div>
</template>

<script lang="ts" setup>
//@ts-nocheck
import { useAppStore } from '@/stores/modules/app'
import LogPng from '@/public/assets/logo.png'
import { warpHost } from '@/support/helper'
import { computed } from 'vue'

const store = useAppStore()
const setting = computed(() => store.getSetting)
</script>
<style scoped>
.logo-bg {
  background-color: var(--header-logo-bg-color);
}

.logo-text {
  color: var(--header-logo-text-color);
}
</style>
