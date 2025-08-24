<template>
  <div class="w-full py-5 md:w-1/2">
    <el-form :model="formData" label-width="100px" ref="form">
      <Freqyency v-model="formData.timeout.frequency" prompt="config('connector.timeout.frequency')" />
      <el-form-item label="超时时间">
        <el-input v-model="formData.timeout.time">
          <template #append>ms</template>
        </el-input>
        <Prompt text="config('connector.timeout.time')" />
      </el-form-item>
      <el-form-item label="百分比">
        <el-input v-model="formData.timeout.rate">
          <template #append>%</template>
        </el-input>
        <div class="flex flex-col">
          <Prompt text="config('connector.timeout.rate')" />
          <Prompt text="如频率选择三十分钟, 超时设置 2000ms, 百分比设置 20时。则三十分钟内超时请求量/请求总量大于百分二十就发出报警" />
        </div>
      </el-form-item>
      <Enable v-model="formData.timeout.enable" prompt="config('connector.timeout.enable')" />
      <div class="flex justify-center">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
      </div>
    </el-form>
  </div>
</template>
<script lang="ts" setup>
import Freqyency from './frequency.vue'
import Enable from './enable.vue'
import { submit } from './submit'
import { ref } from 'vue'

const formData = ref({
  timeout: {
    frequency: 10,
    time: 2000,
    rate: 10,
    enable: false
  }
})

const { form, submitForm, init } = submit(formData)

init(formData, 'timeout')
</script>
