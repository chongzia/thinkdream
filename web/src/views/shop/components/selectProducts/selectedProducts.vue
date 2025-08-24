<template>
  <div>
    <catch-table :columns="columns" :api="api" ref="table" :showHeader="false" :pagination="false" :defaultParams="defaultParams">
      <template #available="scope">
        <div
          v-for="status in [
            { text: '上架中', type: 'primary', value: 1 },
            { text: '已下架', type: 'info', value: 2 },
            { text: '仓库中', type: 'info', value: 3 },
            { text: '已售罄', type: 'danger', value: 4 }
          ]"
          :key="status.value"
        >
          <el-button :type="status.type" v-if="scope.row.is_available === status.value" text>{{ status.text }}</el-button>
        </div>
      </template>
      <template #operate="scope">
        <Destroy @click="destroy(scope.row.id)" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import { onMounted, ref, watch } from 'vue'

const api = 'shop/products'
const modelValue = defineModel<Array<number>>()
const defaultParams = ref({
  ids: modelValue.value?.join(',')
})
// table columns
const columns = [
  {
    prop: 'id',
    label: '商品ID',
    width: 80,
    align: 'center'
  },
  {
    prop: 'images',
    label: '商品主图',
    image: true,
    preview: true,
    width: 150
  },
  {
    prop: 'title',
    label: '商品名称',
    width: 300
  },
  {
    prop: 'stock',
    label: '商品库存',
    width: 100
  },
  {
    prop: 'is_available',
    label: '上架状态',
    width: 100,
    slot: 'available'
  },
  {
    type: 'operate',
    label: '操作',
    update: false,
    destroy: false,
    width: 100
  }
]
const table = ref()

// watch modelValue 获取商品数据
watch(
  () => modelValue.value,
  () => {
    getShopData()
  },
  { deep: true }
)

// 删除商品
const destroy = (id: number) => {
  modelValue.value = modelValue.value?.filter((i: any) => {
    return id !== parseInt(i)
  })
  console.log(modelValue.value)
}

// 动态获取商品数据
const getShopData = () => {
  defaultParams.value.ids = modelValue.value?.join(',')
  table.value.doSearch()
}
onMounted(() => {
  getShopData()
})
</script>
