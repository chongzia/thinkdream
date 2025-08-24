<template>
  <div class="'block text-center" :style="parentStyle">
    <el-carousel height="150px">
      <el-carousel-item v-for="item in swiper.data" :key="item.image">
        <img :src="item.image" class="w-full h-full" :style="`border-radius:${swiper.style.border_radius}px`" v-if="item.image" />
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script lang="ts" setup>
import { computed, watch, ref } from 'vue'
import { swiperComponent } from '../component'

const swiper = defineModel<swiperComponent>({ required: true })

const parentStyle = computed(() => {
  return (
    'background-color:' +
    swiper.value.style.background_color +
    ';padding-top:' +
    swiper.value.style.pt +
    'px' +
    ';padding-left:' +
    swiper.value.style.pl +
    'px' +
    ';padding-right:' +
    swiper.value.style.pr +
    'px' +
    ';padding-bottom:' +
    swiper.value.style.pb +
    'px'
  )
})

const indicator = ref({
  is_show: true,
  active_color: '#FFFFFF',
  inactive_color: 'rgba(255, 255, 255, 0.35)',
  position: 'bottom',
  mode: 'line',
  left: '',
  display: 'inline-block',
  width: '20px',
  height: '2px',
  border_radius: '0px'
})

watch(
  () => swiper.value.style.indicator,
  (newVal, oldValue) => {
    indicator.value = {
      ...newVal,
      display: newVal.is_show ? 'inline-block' : 'none',
      left: newVal.position === 'left' ? '15%' : newVal.position === 'bottom' ? '50%' : '70%',
      width: newVal.mode === 'line' ? '20px' : '5px',
      height: newVal.mode === 'line' ? '2px' : '5px',
      border_radius: newVal.mode === 'line' ? '0px' : '100%'
    }
  },
  { deep: true }
)
</script>
<style scoped>
:deep(.el-carousel__indicator.is-active button) {
  background-color: v-bind('indicator.active_color') !important;
}

:deep(.el-carousel__indicator button) {
  background-color: v-bind('indicator.inactive_color') !important;
  width: v-bind('indicator.width') !important;
  height: v-bind('indicator.height') !important;
  border-radius: v-bind('indicator.border_radius') !important;
}

:deep(.el-carousel__indicators) {
  display: v-bind('indicator.display') !important;
}

:deep(.el-carousel__indicators--horizontal) {
  left: v-bind('indicator.left') !important;
}
</style>
