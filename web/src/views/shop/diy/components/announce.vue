<template>
  <div class="grid items-center h-12 grid-cols-6 gap-x-2" :style="style">
    <div class="col-span-1 text-center text-white bg-red-500 rounded h-7">公告</div>
    <Vue3Marquee class="col-span-5" :vertical="announce.type === 'vertical'">
      <div v-for="(word, index) in announce.data" :key="index" class="w-[300px] h-[40px] leading-[40px]" :style="font">
        {{ word.title }}
      </div>
    </Vue3Marquee>
  </div>
</template>

<script setup lang="ts">
import { Vue3Marquee } from 'vue3-marquee'
import { AnnounceComponent } from '../component'
import { computed } from 'vue'

const announce = defineModel<AnnounceComponent>({ required: true })

const font = computed(() => {
  return `font-size:${announce.value.style.size}px;color:${announce.value.style.color};`
})

const style = computed(() => {
  return `background-color:${announce.value.style.background_color};padding:${announce.value.style.pt}px ${announce.value.style.pr}px ${announce.value.style.pb}px ${announce.value.style.pl}px`
})
</script>
