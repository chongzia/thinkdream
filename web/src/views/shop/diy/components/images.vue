<template>
  <div :style="style">
    <div v-if="images.style.type !== 6 && images.style.type !== 4 && images.style.type !== 5" :class="`grid grid-cols-${images.style.type} gap-1`">
      <div v-for="(item, key) in images.data" :key="key" class="cursor-pointer">
        <img :src="item.image" :class="'w-full h-' + 72 / images.style.type" v-if="item.image" />
        <div v-else :class="'w-full h-' + 72 / images.style.type + ' opacity-55'"></div>
      </div>
    </div>
    <div v-else-if="images.style.type === 4" class="grid grid-flow-col gap-[2px] grid-rows-2">
      <div :class="'cursor-pointer w-full row-span-' + (!key ? 2 : 1) + ' h-' + (!key ? 36 : 18)" v-for="(item, key) in images.data" :key="key">
        <img :src="item.image" class="w-full h-full" v-if="item.image" />
      </div>
    </div>
    <div v-else-if="images.style.type === 5" class="grid grid-cols-4 gap-x-1">
      <div class="w-full h-16 cursor-pointer opacity-55" v-for="(item, key) in images.data" :key="key">
        <img :src="item.image" class="w-full h-full" v-if="item.image" />
      </div>
    </div>
    <div v-else class="grid grid-cols-2 gap-[0.15rem] grid-rows-2">
      <div class="w-full row-span-1 cursor-pointer h-36" v-for="(item, key) in images.data" :key="key">
        <img :src="item.image" class="w-full h-full" v-if="item.image" />
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue'
import { ImagesComponent } from '../component'

const images = defineModel<ImagesComponent>({ required: true })

const style = computed(() => {
  return `background-color:${images.value.style.background_color};padding:${images.value.style.pt}px ${images.value.style.pr}px ${images.value.style.pb}px ${images.value.style.pl}px`
})
</script>
