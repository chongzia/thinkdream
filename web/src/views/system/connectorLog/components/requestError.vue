<template>
  <div class="w-full py-5 md:w-1/2">
    <el-form :model="formData" label-width="100px" ref="form">
      <Freqyency v-model="formData.request_error.frequency" prompt="config('connector.request_error.frequency')" />
      <el-form-item label="HTTP 状态码">
        <el-select v-model="formData.request_error.http_status" placeholder="状态码" multiple allow-create filterable>
          <el-option
            v-for="item in [
              {
                label: '500',
                value: 500
              },
              {
                label: '503',
                value: 503
              },
              {
                label: '404',
                value: 404
              }
            ]"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
        <Prompt text="config('connector.request_error.http_status')" />
      </el-form-item>
      <el-form-item label="百分比">
        <el-input v-model="formData.request_error.rate">
          <template #append>%</template>
        </el-input>
        <div class="flex flex-col">
          <Prompt text="config('connector.request_error.rate')" />
          <Prompt text="如频率选择三十分钟, HTTP 状态码设置 500, 百分比设置 20 时。则三十分钟内 http 状态码是500的请求/请求总量大于百分二十就发出报警" />
        </div>
      </el-form-item>
      <Enable v-model="formData.request_error.enable" prompt="config('connector.request_error.enable')" />
      <div class="flex justify-center">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
      </div>
    </el-form>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import Freqyency from './frequency.vue'
import Enable from './enable.vue'
import { submit } from './submit'

const formData = ref({
  request_error: {
    frequency: 10,
    http_status: [500],
    rate: 10,
    enable: false
  }
})

const { form, submitForm, init } = submit(formData)
init(formData, 'request_error')
</script>
