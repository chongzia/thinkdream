<template>
  <div class="flex flex-col items-center justify-center w-full bg-white dark:bg-regal-dark">
    <el-form :model="setting" label-width="200px" ref="form" v-loading="loading" class="w-1/2 mt-10 mb-10">
      <div class="text-lg text-gray-600">充值设置</div>
      <el-form-item label="是否开启会员充值" prop="is_enable" class="mt-2" :rules="[{ required: true }]">
        <div class="flex flex-col">
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
          <Prompt text="如果选择关闭，则前台会员充值功能关闭" />
          <Prompt text="config('recharge.is_enable')" />
        </div>
      </el-form-item>

      <el-form-item label="充值自定义金额" prop="is_define_price" class="mt-2" :rules="[{ required: true }]">
        <div class="flex flex-col">
          <el-radio-group v-model="setting.is_define_price">
            <el-radio
              v-for="item in [
                { value: 1, label: '允许' },
                { value: 0, label: '不允许' }
              ]"
              :key="item.value"
              :value="item.value"
              >{{ item.label }}</el-radio
            >
          </el-radio-group>
          <Prompt text="是否允许用户填写自定义的充值金额" />
          <Prompt text="config('recharge.is_define_price')" />
        </div>
      </el-form-item>

      <el-form-item label="最低充值金额" prop="min_recharge_price" :rules="[{ required: true, message: '单笔满多少元必须填写' }]" v-if="setting.is_define_price">
        <div class="flex flex-col">
          <div>
            <el-input-number v-model="setting.min_recharge_price" control-position="right" :min="0" />
            <span class="ml-5 text-gray-500">元</span>
          </div>
          <div>
            <Prompt text="低于该设定金额时不允许充值" />
            <Prompt text="config('recharge.min_recharge_price')" />
          </div>
        </div>
      </el-form-item>

      <el-form-item label="自动匹配套餐" prop="is_auto_match" class="mt-2" :rules="[{ required: true }]">
        <div class="flex flex-col">
          <el-radio-group v-model="setting.is_auto_match">
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
          <Prompt text="充值自定义金额时 是否自动匹配充值套餐，如不开启则不参与套餐金额赠送" />
          <Prompt text="config('recharge.is_auto_match')" />
        </div>
      </el-form-item>

      <el-form-item label="充值说明" :rules="[{ required: true, message: '充值说明必须填写' }]" prop="introduce">
        <el-input v-model="setting.introduce" :rows="5" type="textarea" placeholder="请输入充值说明" />
        <Prompt text="config('recharge.introduce')" />
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

interface settingInterface {
  is_enable: number // 积分名称
  is_define_price: number // 是否自定义最低充值金额
  min_recharge_price: number // 最低充值金额
  is_auto_match: number // 自动匹配套餐
  introduce: string
}
const setting = ref<settingInterface>({
  is_enable: 1,
  is_define_price: 1,
  min_recharge_price: 1,
  is_auto_match: 1,
  introduce: ''
})

const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('shop/config/vip/recharge', setting.value).then(r => {
        Message.success('会员充值设置成功')
      })
    }
  })
}

const getSetting = () => {
  http.get('shop/config/vip/recharge').then(r => {
    setting.value = Object.assign(setting.value, r.data.data)
  })
}
onMounted(() => {
  getSetting()
})
</script>
