<template>
  <div>
    <div :class="sideClass + ' drop-shadow-md'">
      <!--logo -->
      <Logo />
      <div class="h-screen overflow-auto pb-36 overflow-y">
        <!-- menu item -->
        <Menu :menu-class="'pt-2 ' + menuClass" />
      </div>
      <div class="fixed bottom-0 flex items-center justify-center w-full h-16 p-4 mt-auto bg-white border-t cursor-pointer dark:border-t-gray-800 shadow-lg-1 dark:bg-regal-dark">
        <Icon name="arrows-right-left" className="w-6 h-6" v-if="!appStore.getVertical" @click="appStore.setVertical(true)" />
        <Icon name="arrows-up-down" v-else @click="appStore.setVertical()" className="w-6 h-6" />
      </div>
    </div>
    <Mask v-if="isMobile && appStore.isExpand" @click="appStore.changeExpaned()" />
  </div>
</template>

<script lang="ts" setup>
import { useAppStore } from '@/stores/modules/app'
import { computed, onMounted, ref, watch } from 'vue'
import { isMiniScreen } from '@/support/helper'

const isMobile = ref(isMiniScreen())
const layoutSide = ' h-screen z-[1000] sm:z-0 absolute top-0 left-0 sm:fixed transition-width duration-300 ease-linear sider-bg'
const layoutSideOpenClass = 'w-56' + layoutSide
const layoutSideHiddenClass = 'w-0 sm:w-16' + layoutSide

// 是否是小屏幕
const sideClass = computed(() => {
  return appStore.isExpand ? layoutSideOpenClass : layoutSideHiddenClass
})

// menu class
const menuClass = ref<string>()
// 判断展开状态
const appStore = useAppStore()
watch(appStore.$state, state => {
  // 如果切换到小屏幕，并且是菜单是收缩状态
  menuClass.value = isExpandWhenInMobile()
})

// 监控屏幕大小
onMounted(() => {
  window.onresize = () => {
    return (() => {
      // 如果切换到小屏幕，并且是菜单是收缩状态，则隐藏子菜单
      isMobile.value = isMiniScreen()
      menuClass.value = isExpandWhenInMobile()
    })()
  }

  // 刷新或者 go back 的时候默认展开菜单
  appStore.isExpand = true
})

function isExpandWhenInMobile(): string {
  return !appStore.isExpand && isMobile.value ? 'hidden' : ''
}
</script>

<style scoped>
.sider-bg {
  background-color: var(--sider-menu-bg-color);
}

/* 自定义滚动条样式 */
.overflow-y::-webkit-scrollbar {
  width: 2px;
}

.overflow-y::-webkit-scrollbar-track {
  background: transparent;
}

.overflow-y::-webkit-scrollbar-thumb {
  background: rgba(144, 147, 153, 0.3);
  border-radius: 25px;
  transition: background-color 0.3s;
}

.overflow-y::-webkit-scrollbar-thumb:hover {
  background: rgba(144, 147, 153, 0.5);
}

/* Firefox 滚动条样式 */
.overflow-y {
  scrollbar-width: thin;
  scrollbar-color: rgba(144, 147, 153, 0.3) transparent;
}
</style>
