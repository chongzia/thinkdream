<template>
  <div class="mt-3 bg-white dark:bg-regal-dark pl-5 pr-5 pb-5">
    <el-tabs v-model="activeName" class="ctabs">
      <el-tab-pane :label="tab.label" :name="tab.name" v-for="(tab, key) in tabs" :key="key">
        <KeepAlive v-if="show">
          <component :is="tab.component" v-if="tab.name == activeName" ref="product" :next="next" />
        </KeepAlive>
        <div v-else class="h-[46rem] w-1/2" v-loading="loading" element-loading-text="产品数据加载中..." />
      </el-tab-pane>
    </el-tabs>
    <div class="flex gap-2 w-3/5 justify-center items-center">
      <el-button v-if="activeName != 'basic'" @click="prev">上一步</el-button>
      <el-button type="primary" v-if="activeName == 'config'" @click="save()">保存</el-button>
      <el-button type="primary" v-if="activeName != 'config'" @click="validate()">下一步</el-button>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref, watch, shallowRef, computed } from 'vue'
import basic from '../components/basic.vue'
import spec from '../components/spec.vue'
import detail from '../components/detail.vue'
import config from '../components/config.vue'
import ship from '../components/ship.vue'
import { useProductStore } from '../store'
import { isUndefined } from '@/support/helper'
import http from '@/support/http'
import router from '@/router'
import Message from '@/support/message'
import { Code } from '@/enum/app'

// tab 初始化
const originTabs = () => {
  return [
    { label: '基本信息', name: 'basic', component: basic },
    { label: '库存价格', name: 'spec', component: spec },
    { label: '商品详情', name: 'detail', component: detail },
    { label: '物流设置', name: 'ship', component: ship },
    { label: '高级配置', name: 'config', component: config }
  ]
}

const tabs = shallowRef(originTabs())

const activeName = ref('basic')
const product = ref()
const loading = ref(false)
const show = ref(true)
// 监听类型，切换 tab
const productStore = useProductStore()

const id = router.currentRoute.value.params.id
const getProduct = () => {
  if (id) {
    productStore.setId(id)
    show.value = false
    loading.value = true
    http.get('shop/products/' + id).then(r => {
      const { basic, info, specifications } = r.data.data
      show.value = true
      loading.value = false
      productStore.setBasic(basic)
      productStore.setInfo(info)
      productStore.setSpecifications(specifications)
    })
  } else {
    productStore.initProduct()
  }
}

getProduct()
const productBasic = computed(() => productStore.getBasic)

watch(
  () => productBasic.value.type,
  () => {
    if (productBasic.value.type !== 1) {
      tabs.value = tabs.value.filter(tab => {
        return tab.name !== 'ship'
      })
    } else {
      tabs.value = originTabs()
    }
  }
)
// form 表单验证
// 由子组件定义实现
const validate = () => {
  if (!isUndefined(product.value[0].submit)) {
    product.value[0].submit()
  }
}

// 下一步
const next = () => {
  for (let i = 0; i < tabs.value.length; i++) {
    if (tabs.value[i].name === activeName.value) {
      activeName.value = tabs.value[i + 1].name
      break
    }
  }
}

// 上一步
const prev = () => {
  for (let i = 0; i < tabs.value.length; i++) {
    if (tabs.value[i].name === activeName.value) {
      activeName.value = tabs.value[i - 1].name
      break
    }
  }
}

// 保存
const save = () => {
  if (id) {
    http.put('shop/products/' + id, productStore.$state).then(r => {
      if (r.data.code === Code.SUCCESS) {
        Message.success('产品更新成功')
        goShopIndex()
      }
    })
  } else {
    http.post('shop/products', productStore.$state).then(r => {
      if (r.data.code === Code.SUCCESS) {
        Message.success('新增产品成功')
        goShopIndex()
      }
    })
  }
}
const goShopIndex = () => {
  setTimeout(() => {
    router.push({ path: '/shop/goods/products' })
  }, 800)
}
</script>
<style>
.ctabs > .el-tabs__content {
  padding: 32px;
  color: #6b778c;
  font-size: 32px;
}
</style>
