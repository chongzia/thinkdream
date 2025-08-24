<template>
  <div>
    <div class="pl-5">
      <el-button plain @click="visible = true">选择商品</el-button>
    </div>
    <Dialog v-model="visible" width="1300px" destroy-on-close>
      <SelectProducts v-model="shops" @close="visible = false" />
    </Dialog>
    <div>
      <SelectedProducts v-if="shops?.length > 0" v-model="shops" />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import SelectProducts from './selectProducts.vue'
import SelectedProducts from './selectedProducts.vue'
const shops = defineModel<Array<any>>({
  default: []
})
const visible = ref(false)
</script>
