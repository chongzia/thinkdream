<template>
  <div class="flex items-center h-12" :style="style">
    <div :style="font" class="w-full p-2">
      {{ title.data.title }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { TitleComponent } from '../component'
import { computed } from 'vue'

const title = defineModel<TitleComponent>({ required: true })

const font = computed(() => {
  return `font-size:${title.value.style.size}px;color:${title.value.style.color};text-align:${title.value.style.position}`
})

const style = computed(() => {
  return `background-color:${title.value.style.background_color};padding:${title.value.style.pt}px ${title.value.style.pr}px ${title.value.style.pb}px ${title.value.style.pl}px`
})
</script>
