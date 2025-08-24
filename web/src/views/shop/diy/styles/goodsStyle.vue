<template>
  <div>
    <div class="flex items-center h-10 pl-5 pr-5 text-base border-b border-gray-200">{{ goods.title }}</div>
    <el-tabs v-model="activeName" class="pl-2 pr-2">
      <el-tab-pane label="内容" name="content">
        <el-form-item label="商品分类" class="flex justify-between">
          <Cascade v-model="goods.category_ids" placeholder="请选择商品分类" clearable multiple api="shop/category" />
        </el-form-item>
        <el-form-item label="商品排序">
          <el-radio-group v-model="goods.sort" size="small">
            <el-radio-button value="all">综合</el-radio-button>
            <el-radio-button value="price">价格</el-radio-button>
            <el-radio-button value="sales">销量</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="商品数量">
          <el-input-number v-model="goods.goods_number" :min="1" :max="10" />
        </el-form-item>
        <el-form-item label="是否显示标题"> <el-switch v-model="goods.is_show_title" /> </el-form-item>
        <el-form-item label="是否显示价格"> <el-switch v-model="goods.is_show_price" /> </el-form-item>
        <el-form-item label="是否显示划线价"> <el-switch v-model="goods.is_show_list_price" /> </el-form-item>
        <el-form-item label="是否显示优惠卷"> <el-switch v-model="goods.is_show_coupon" /> </el-form-item>
      </el-tab-pane>
      <el-tab-pane label="样式" name="style">
        <el-card shadow="never">
          <template #header>
            <div>样式设置</div>
          </template>
          <div>
            <div class="flex flex-col">
              <el-form-item label="价格颜色">
                <el-color-picker v-model="goods.style.price_color" size="small" />
              </el-form-item>
              <el-form-item label="展示列数">
                <el-radio-group v-model="goods.style.cols" size="small">
                  <el-radio-button :value="1">一列</el-radio-button>
                  <el-radio-button :value="2">二列</el-radio-button>
                  <el-radio-button :value="3">三列</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="背景颜色">
                <el-color-picker v-model="goods.style.background_color" size="small" />
              </el-form-item>
              <el-form-item label="上边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="goods.style.pt" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ goods.style.pt }}</div>
                </div>
              </el-form-item>
              <el-form-item label="下边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="goods.style.pb" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ goods.style.pb }}</div>
                </div>
              </el-form-item>
              <el-form-item label="左边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="goods.style.pl" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ goods.style.pl }}</div>
                </div>
              </el-form-item>
              <el-form-item label="右边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="goods.style.pr" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ goods.style.pr }}</div>
                </div>
              </el-form-item>
            </div>
          </div>
        </el-card>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { GoodsComponent } from '../component'
import http from '@/support/http'

const goods = defineModel<GoodsComponent>({ required: true })

const activeName = ref('content')

const getGoods = () => {
  let categoryIds: Array<number> = []
  goods.value.category_ids?.forEach(item => {
    categoryIds = categoryIds.concat(item)
  })

  if (categoryIds.length > 0) {
    http
      .get('shop/diy/category/products', {
        category_ids: categoryIds.join(','),
        sort: goods.value.sort,
        limit: goods.value.goods_number
      })
      .then(r => {
        goods.value.data = r.data.data
      })
  }
}
watch(
  () => [goods.value.category_ids, goods.value.sort, goods.value.goods_number],
  (newCategoryIds, oldCategoryIds) => {
    getGoods()
  }
)
</script>

<style scoped>
.el-card__header {
  padding: 5px !important;
}
.el-card__body {
  .el-form-item__label {
    font-size: 13px !important;
  }
}
</style>
