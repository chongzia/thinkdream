<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false" ref="table" :multiDelShow="false" :defaualtMultiSelection="modelValue">
      <template #operation>
        <el-button-group class="ml-2">
          <el-button
            plain
            class="border-gray-200"
            @click="searchStatus(item.value)"
            v-for="item in [
              { label: '上架中', value: 1 },
              { label: '仓库中', value: 3 },
              { label: '已下架', value: 2 },
              { label: '已售罄', value: 4 }
            ]"
            :key="item.value"
            >{{ item.label }}</el-button
          >
        </el-button-group>
        <div class="flex w-96 gap-x-2">
          <el-input v-model="title" placeholder="请选择商品名称" clearable />
          <el-tree-select v-model="categoryId" value-key="id" clearable placeholder="请选择分类" :data="categories" check-strictly :props="{ label: 'name' }" />
          <el-button type="primary" @click="search">搜索</el-button>
        </div>
      </template>
      <template #multiOperate>
        <div>
          <el-button type="primary" @click="multiOperate()">确定</el-button>
        </div>
      </template>
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
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import http from '@/support/http'
import { ref, onMounted } from 'vue'
const api = 'shop/products'
const modelValue = defineModel()
const categories = ref()
// table columns
const columns = [
  {
    type: 'selection'
  },
  {
    prop: 'id',
    label: '商品ID',
    width: 80
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
    label: '商品名称'
  },
  {
    prop: 'price',
    label: '商品售价',
    width: 150
  },
  {
    prop: 'sales',
    label: '商品销量',
    width: 150
  },
  {
    prop: 'stock',
    label: '商品库存',
    width: 150
  },
  {
    prop: 'is_available',
    label: '上架状态',
    width: 150,
    slot: 'available'
  },
  {
    prop: 'sort',
    label: '商品排序',
    sortable: true,
    width: 150
  },
  {
    prop: 'created_at',
    label: '创建时间',
    width: 200
  }
]

const table = ref()

const multiOperate = () => {
  modelValue.value = table.value.getMultiSelectIds()
  close()
}

const title = ref('')
const categoryId = ref(null)
const searchStatus = (val: number) => {
  table.value.doSearch({
    is_available: val
  })
}
const search = () => {
  table.value.doSearch({
    title: title.value,
    category_id: categoryId.value
  })
}
onMounted(() => {
  http.get('shop/category').then(r => {
    categories.value = r.data.data
  })
})

const emit = defineEmits(['close'])
function close() {
  emit('close')
}
</script>
