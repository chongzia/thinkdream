<template>
  <div class="w-full py-5 md:w-1/2">
    <el-form :model="formData" label-width="100px" ref="form">
      <Freqyency v-model="formData.requests.frequency" prompt="config('connector.requests.frequency')" />
      <el-form-item label="最大请求量">
        <el-input v-model="formData.requests.max"> </el-input>
        <div class="flex flex-col">
          <Prompt text="config('connector.requests.max')" />
          <Prompt text="如频率选择三十分钟, 最大请求量设置 2000。则三十分钟内请求总量大于2000就发出报警" />
        </div>
      </el-form-item>
      <Enable v-model="formData.requests.enable" prompt="config('connector.requests.enable')" />
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
  requests: {
    frequency: 10,
    max: 2000,
    enable: false
  }
})

const { form, submitForm, init } = submit(formData)

init(formData, 'requests')
</script>
