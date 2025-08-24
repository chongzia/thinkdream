<template>
  <div class="flex flex-col w-full p-5 bg-white dark:bg-regal-dark">
    <el-divider content-position="left" class="text-lg">新增秒杀商品</el-divider>
    <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="w-full lg:w-2/3 xl:w-1/2">
      <el-form-item label="选择秒杀商品" prop="product_id" :rules="[{ required: true, message: '请选择秒杀商品' }]">
        <SelectProducts v-model="formData.product_id" class="-ml-5" />
      </el-form-item>
      <el-form-item label="秒杀价格" prop="seckill_price" :rules="[{ required: true, message: '请设置秒杀价格' }]">
        <div class="flex flex-col">
          <div>
            <el-input-number v-model="formData.seckill_price" name="seckill_price" :min="1" controls-position="right" />
            <span class="ml-2 text-gray-500">元</span>
          </div>
          <Prompt text="设置秒杀价格" />
        </div>
      </el-form-item>
      <el-form-item label="秒杀库存" prop="stock" :rules="[{ required: true, message: '请设置秒杀库存' }]">
        <el-input-number v-model="formData.stock" name="stock" :min="1" controls-position="right" />
        <span class="ml-2 text-gray-500">件</span>
      </el-form-item>
      <el-form-item label="限购数量" prop="limit_per_user" :rules="[{ required: true, message: '请设置限购数量' }]">
        <div class="flex flex-col">
          <div>
            <el-input-number v-model="formData.limit_per_user" name="limit_per_user" :min="0" controls-position="right" />
            <span class="ml-2 text-gray-500">件</span>
          </div>
          <Prompt text="每人限制购买的数量，如果填写0则不限购" />
        </div>
      </el-form-item>
      <el-form-item label="库存计算方式" prop="stock_reduce_type" :rules="[{ required: true, message: '请设置库存计算方式' }]">
        <div class="flex flex-col">
          <el-radio-group v-model="formData.stock_reduce_type">
            <el-radio
              v-for="item in [
                { value: 1, label: '下单减库存' },
                { value: 2, label: '付款减库存' }
              ]"
              :key="item.value"
              :value="item.value"
              name="stock_reduce_type"
              >{{ item.label }}</el-radio
            >
          </el-radio-group>
          <Prompt text="为防止超卖风险请选择下单减库存选项" />
          <div v-if="formData.stock_reduce_type === 2" class="text-red-500">该选项会引起超卖，请尽量不要选择</div>
        </div>
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="formData.status">
          <el-radio
            v-for="item in [
              { value: 1, label: '上架' },
              { value: 2, label: '下架' }
            ]"
            :key="item.value"
            :value="item.value"
            name="status"
            >{{ item.label }}</el-radio
          >
        </el-radio-group>
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="formData.sort" name="sort" :min="1" controls-position="right" />
      </el-form-item>
      <div class="flex w-full mx-auto lg:w-2/3 xl:w-1/2 gap-x-2">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
        <router-link :to="path">
          <el-button>返回</el-button>
        </router-link>
      </div>
    </el-form>
  </div>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { useCreate } from '@/composables/curd/useCreate'
import SelectProducts from '@/views/shop/components/selectProducts/index.vue'
import { useShow } from '@/composables/curd/useShow'
import router from '@/router'

const api = 'shop/seckill/products'
const primary = router.currentRoute.value.params.id
const path = '/shop/market/seckill/products'
const { formData, form, loading, submitForm, afterCreate, afterUpdate } = useCreate(api, primary)

formData.value.sort = 1
formData.value.status = 1
formData.value.stock_reduce_type = 1
formData.value.limit_per_user = 1

if (primary) {
  const { afterShow } = useShow(api as string, primary, formData)
  afterShow.value = () => {
    formData.value.product_id = [formData.value.product_id]
  }
}

afterCreate.value = () => {
  backGo()
}

afterUpdate.value = () => {
  backGo()
}
const backGo = () => {
  router.push({ path })
}
</script>
