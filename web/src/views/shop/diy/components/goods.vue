<template>
  <div :class="'grid grid-cols-' + goods.style.cols" :style="style">
    <div v-for="(item, key) in goods.data" :key="key" :class="'p-2 grid gap-x-4' + (goods.style.cols === 1 ? ' grid-cols-3' : ' grid-rows-1')">
      <div class="col-span-1 border border-red-50 w-28 h-28">
        <img :src="item.images[0]" class="w-full h-full" />
      </div>
      <div :class="'relative col-span-2' + (goods.style.cols === 1 ? '' : ' h-20')">
        <div class="mt-2 text-base truncate w-28" v-show="goods.is_show_title">{{ item.title }}</div>
        <p class="text-sm text-gray-300 line-through" v-show="goods.is_show_list_price">￥{{ item.list_price }}</p>

        <div class="absolute bottom-0 flex">
          <p class="text-lg text-red-500" :style="priceColor" v-show="goods.is_show_price">￥{{ item.price }}</p>
          <p v-show="goods.is_show_coupon" class="flex items-center w-6 h-6 p-1 mt-[1px] ml-2 text-sm text-center text-red-500 border border-red-500 rounded">券</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue'
import { GoodsComponent } from '../component'

const goods = defineModel<GoodsComponent>({ required: true })

const priceColor = computed(() => {
  return 'color:' + goods.value.style.price_color
})

const style = computed(() => {
  return `background-color:${goods.value.style.background_color};padding:${goods.value.style.pt}px ${goods.value.style.pr}px ${goods.value.style.pb}px ${goods.value.style.pl}px`
})
</script>
