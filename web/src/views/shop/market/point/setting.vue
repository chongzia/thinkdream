<template>
  <div class="flex flex-col items-center justify-center w-full bg-white dark:bg-regal-dark">
    <el-form :model="setting" label-width="200px" ref="form" v-loading="loading" class="w-1/2 mt-10 mb-10">
      <div class="text-lg text-gray-600">积分设置</div>

      <el-form-item label="积分名称" :rules="[{ required: true, message: '积分名称必须填写' }]" prop="title">
        <el-input v-model="setting.title" />
        <div>
          <Prompt text="积分名称可以自定义，例如淘宝称为“淘金币”" />
          <Prompt text="config('point.title')" />
        </div>
      </el-form-item>

      <el-form-item label="积分说明" :rules="[{ required: true, message: '积分说明必须填写' }]" prop="title">
        <el-input v-model="setting.introduce" :rows="5" type="textarea" placeholder="请输入积分说明" />
        <Prompt text="config('point.introduce')" />
      </el-form-item>

      <el-divider content-position="left">积分赠送</el-divider>
      <el-form-item label="下单送积分" prop="is_handsel" :rules="[{ required: true, message: '请选择优惠卷类型' }]">
        <div class="flex flex-col">
          <el-radio-group v-model="setting.is_handsel">
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
          <div class="block">
            <Prompt text="订单确认收货已完成 OR 已完成订单超出后台设置的申请售后期限" />
            <Prompt text="config('point.is_handsel')" />
          </div>
        </div>
      </el-form-item>
      <el-form-item v-if="setting.is_handsel === 1" label="积分赠送比例" prop="is_handsel" :rules="[{ required: true, message: '请填写积分赠送比例' }]">
        <div class="flex flex-col">
          <div class="flex"><el-input-number v-model="setting.handsel_rate" controls-position="right" /> <span class="ml-2">%</span></div>
          <div>
            <Prompt text="赠送的积分数 是使用订单金额 * 积分比例，例如订单金额 100 元，比例 5%. 那么就是赠送 100 * 5% = 5 积分" />
            <Prompt text="config('point.handsel_rate')" />
          </div>
        </div>
      </el-form-item>
      <el-divider content-position="left">积分抵扣</el-divider>
      <el-form-item label="下单使用积分抵扣" prop="is_order_deduct_point" :rules="[{ required: true, message: '请选择是否使用积分抵扣' }]">
        <div class="flex flex-col">
          <el-radio-group v-model="setting.is_order_deduct_point">
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
          <div class="block">
            <Prompt text="开启后用户下单时可选择使用积分抵扣订单金额" />
            <Prompt text="config('point.is_order_deduct_point')" />
          </div>
        </div>
      </el-form-item>
      <div v-if="setting.is_order_deduct_point === 1">
        <el-form-item label="积分抵扣比例" prop="is_order_deduct_point" :rules="[{ required: true, message: '请选择是否使用积分抵扣' }]">
          <div class="flex flex-col">
            <el-input v-model="setting.deduct_rate" placeholder="请输入抵扣金额" style="width: 260px">
              <template #prepend>1 积分可以抵扣</template>
              <template #append>元</template>
            </el-input>
            <div class="block">
              <Prompt text="默认 1 积分抵扣多少，如 1 积分抵扣 1 元，那么 100 积分则可以抵扣 100 元" />
              <Prompt text="config('point.deduct_rate')" />
            </div>
          </div>
        </el-form-item>
        <el-form-item label="最高可抵扣金额" prop="is_order_deduct_point" :rules="[{ required: true, message: '请选择是否使用积分抵扣' }]">
          <div class="flex flex-col">
            <el-input v-model="setting.max_reduce" placeholder="请输入满减金额" style="width: 260px">
              <template #prepend>订单满 </template>
              <template #append>元</template>
            </el-input>
            <Prompt text="config('point.max_reduce')" />
            <el-input v-model="setting.max_reduce_rate" placeholder="请输入最高可抵扣金额" style="width: 260px">
              <template #prepend>最高可抵扣金额 </template>
              <template #append>%</template>
            </el-input>
            <Prompt text="config('point.max_reduce_rate')" />
            <div class="block">
              <Prompt text="如果设置最高可抵扣1%，订单金额100元，此时用户可抵扣1元" />
            </div>
          </div>
        </el-form-item>
      </div>
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
  title: string // 积分名称
  introduce: string // 积分说明
  is_handsel: number // 是否开启赠送积分
  handsel_rate: number // 赠送比例
  is_order_deduct_point: number // 是否开启下单积分抵扣
  deduct_rate: number // 抵扣比例
  max_reduce: number // 满多少金额抵扣
  max_reduce_rate: number // 最高可以抵扣金额，比例
}
const setting = ref<settingInterface>({
  title: '',
  introduce: '',
  is_handsel: 1,
  handsel_rate: 0,
  is_order_deduct_point: 1,
  deduct_rate: 0.01,
  max_reduce: 0,
  max_reduce_rate: 0
})

const loading = ref(false)
const form = ref<FormInstance>()
const submitForm = (form: FormInstance | undefined) => {
  if (!form) return
  form.validate(valid => {
    if (valid) {
      http.post('shop/point/setting', setting.value).then(r => {
        Message.success('积分设置成功')
      })
    }
  })
}

const getSetting = () => {
  http.get('shop/point/setting').then(r => {
    setting.value = Object.assign(setting.value, r.data.data)
  })
}
onMounted(() => {
  getSetting()
})
</script>
