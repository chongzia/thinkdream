<template>
  <div class="flex flex-col items-center justify-center w-full bg-white dark:bg-regal-dark">
    <el-form :model="setting" label-width="200px" ref="form" v-loading="loading" class="w-1/2 mt-10 mb-10">
      <div class="text-lg text-gray-600">满额包邮</div>
      <el-form-item label="是否开启满额包邮" prop="is_enable" class="mt-2" :rules="[{ required: true }]">
        <el-radio-group v-model="setting.is_enable">
          <el-radio
            v-for="item in [
              { value: 1, label: '开启' },
              { value: 0, label: '关闭' }
            ]"
            :key="item.value"
            :value="item.value"
            >{{ item.label }}</el-radio
          >
        </el-radio-group>
        <Prompt text="config('ship.is_enable')" class="ml-5" />
      </el-form-item>
      <el-form-item label="单笔订单满" prop="max_reduce" :rules="[{ required: true, message: '单笔满多少元必须填写' }]">
        <div class="flex flex-col">
          <div>
            <el-input-number v-model="setting.max_reduce" postion="right" :min="0" />
            <span class="ml-5 text-gray-500">元包邮</span>
          </div>
          <div>
            <Prompt text="0元代表全场包邮" />
            <Prompt text="config('ship.max_reduce')" />
          </div>
        </div>
      </el-form-item>
      <el-form-item label="不参与包邮的商品" prop="exclude_ship_products">
        <SelectProducts v-model="setting.exclude_ship_products" class="-ml-5" />
        <Prompt text="config('ship.exclude_ship_products')" class="ml-5" />
      </el-form-item>
      <el-form-item label="不参与包邮的地区" prop="exclude_ship_areas">
        <AreaTree v-model="setting.exclude_ship_areas" />
        <Prompt text="config('ship.exclude_ship_areas')" class="ml-5" />
      </el-form-item>
      <el-form-item label="满额包邮说明" :rules="[{ required: true, message: '满额包邮说明必须填写' }]" prop="introduce">
        <el-input v-model="setting.introduce" :rows="5" type="textarea" placeholder="请输入满额包邮说明" />
        <Prompt text="config('ship.introduce')" />
      </el-form-item>
      <div class="flex justify-center mt-2">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
      </div>
    </el-form>
  </div>
</template>
<script lang="ts" setup>
import { onMounted, ref } from 'vue'
import type { FormInstance } from 'element-plus'
import http from '@/support/http'
import Message from '@/support/message'
import SelectProducts from '@/views/shop/components/selectProducts/index.vue'

interface settingInterface {
  is_enable: number // 积分名称
  max_reduce: number | null // 满多少金额包邮
  exclude_ship_products: Array<number>
  exclude_ship_areas: Array<number>
  introduce: string
}
const setting = ref<settingInterface>({
  is_enable: 1,
  max_reduce: null,
  exclude_ship_products: [],
  exclude_ship_areas: [],
  introduce: ''
})

const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('shop/config/free/shipping', setting.value).then(r => {
        Message.success('满额包邮成功')
      })
    }
  })
}

const getSetting = () => {
  http.get('shop/config/free/shipping').then(r => {
    setting.value = Object.assign(setting.value, r.data.data)
  })
}
onMounted(() => {
  getSetting()
})
</script>
