<template>
  <div :class="'w-full h-screen flex flex-col transition-spacing duration-300 ease-linear overflow-hidden ' + mlClass">
    <!-- Header -->
    <Header />
    <!-- Container -->
    <div class="max-w-full p-1 overflow-auto sm:p-3 sm:overflow-x-hidden dark:bg-regal-deep-dark">
      <div class="min-h-[calc(100vh-8rem)]">
        <router-view v-slot="{ Component }">
          <transition name="fade-transform" mode="out-in">
            <!--<keep-alive v-if="isKeepalive">
              <component :is="Component" :key="routeKey" />
            </keep-alive>
            <component :is="Component" :key="routeKey" v-else />
            -->
            <component :is="Component" :key="routeKey" />
          </transition>
        </router-view>
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue'
import { useAppStore } from '@/stores/modules/app'
import router from '@/router'
const appStore = useAppStore()
const mlClass = computed(() => {
  return appStore.isExpand ? 'ml-0 sm:ml-56' : 'ml-0 sm:ml-16'
})

// const isKeepalive = computed(() => router.currentRoute.value.meta.keepalive)
const routeKey = computed(() => router.currentRoute.value.name)

const year = computed(() => {
  const date = new Date()

  return date.getFullYear()
})
</script>
