<template>
  <div class="p-2">
    <div class="block text-center" :style="parentStyle">
      <input :placeholder="search.placeholder" :style="style" placeholder-style="text-align:center" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { watch, ref } from 'vue'
import { searchComponent } from '../component'
const search = defineModel<searchComponent>({ required: true })

const style = ref('')
const parentStyle = ref('')

const size = ref(search.value.style.size + 'px')
watch(
  () => search,
  (newValue, oldValue) => {
    style.value = `width:100%;border: 1px solid rgb(203 213 225);padding:4px;outline:none;border-radius:${newValue.value.style.border_radius}px`

    parentStyle.value = `background-color:${newValue.value.style.background_color};padding:${newValue.value.style.pt}px ${newValue.value.style.pr}px ${newValue.value.style.pb}px ${newValue.value.style.pl}px`
    console.log(newValue)

    size.value = newValue.value.style.size + 'px'
  },
  { immediate: true, deep: true }
)
</script>
<style scoped>
input::placeholder {
  color: v-bind('search.style.color');
  text-align: v-bind('search.style.position');
  font-size: v-bind('size');
}
</style>
