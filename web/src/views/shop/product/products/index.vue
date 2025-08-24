<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" :operation="false" ref="table">
      <template #operation>
        <router-link to="/shop/goods/product/save">
          <el-button type="primary">添加产品</el-button>
        </router-link>
        <el-radio-group v-model="isAvailable">
          <el-radio-button
            :label="item.label"
            :value="item.value"
            @click="searchStatus(item.value)"
            :key="item.value"
            v-for="item in [
              { label: '上架中', value: 1 },
              { label: '仓库中', value: 3 },
              { label: '已下架', value: 2 },
              { label: '已售罄', value: 4 }
            ]"
          />
        </el-radio-group>
      </template>
      <template #_operate="scope">
        <router-link :to="'/shop/goods/product/save/' + scope.row.id">
          <Update />
        </router-link>
      </template>
      <template #multiOperate>
        <div>
          <el-dropdown>
            <el-button type="primary" size="small" plain> 批 量 操 作 </el-button>
            <template #dropdown>
              <el-dropdown-menu>
                <el-dropdown-item @click="multiOperate('shelf')">批量上架</el-dropdown-item>
                <el-dropdown-item @click="multiOperate('unshelf')">批量下架</el-dropdown-item>
                <el-dropdown-item @click="multiOperate('delist')">放入仓库</el-dropdown-item>
              </el-dropdown-menu>
            </template>
          </el-dropdown>
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
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
    </catch-table>
  </div>
</template>

<script lang="ts" setup>
import http from '@/support/http'
import Create from './form/create.vue'
import { ref, onMounted } from 'vue'
import { Code } from '@/enum/app'
import Message from '@/support/message'
const api = 'shop/products'

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
  },
  {
    type: 'operate',
    label: '操作',
    update: false,
    width: 300
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'title',
    label: '商品名称'
  },
  {
    type: 'tree',
    name: 'category_id',
    label: '商品分类',
    options: categories,
    props: {
      label: 'name'
    }
  }
]

const table = ref()
const isAvailable = ref()
const multiOperate = (operate: string) => {
  http.put(api + '/' + operate + '/' + table.value.getMultiSelectIds().join(',')).then(r => {
    if (r.data.code === Code.SUCCESS) {
      Message.success(r.data.message)
      table.value.doSearch()
    }
  })
}

const searchStatus = (val: number) => {
  isAvailable.value = val
  table.value.doSearch({
    is_available: isAvailable.value
  })
}
onMounted(() => {
  http.get('shop/category').then(r => {
    categories.value = r.data.data
  })
})
</script>
