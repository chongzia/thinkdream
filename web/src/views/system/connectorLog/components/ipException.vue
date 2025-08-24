<template>
  <div class="w-full py-5 md:w-1/2">
    <el-form :model="formData" label-width="100px" ref="form">
      <Freqyency v-model="formData.ip_exception.frequency" prompt="config('connector.ip_exception.frequency')" />
      <el-form-item label="IP白名单">
        <el-input v-model="formData.ip_exception.white_list" />
        <div class="flex flex-col">
          <Prompt text="config('connector.ip_exception.white_list')" />
          <Prompt text="多个ip用'逗号'隔开" />
        </div>
      </el-form-item>
      <el-form-item label="百分比">
        <el-input v-model="formData.ip_exception.rate">
          <template #append>%</template>
        </el-input>
        <div class="flex flex-col">
          <Prompt text="config('connector.ip_exception.rate')" />
          <Prompt text="如频率选择三十分钟, 百分比设置 20%。则某个 IP 请求量占比20%就发出报警，但是白名单的除外" />
        </div>
      </el-form-item>
      <Enable v-model="formData.ip_exception.enable" prompt="config('connector.ip_exception.enable')" />

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
  ip_exception: {
    frequency: 10,
    white_list: 2000,
    rate: 10,
    enable: false
  }
})

const { form, submitForm, init } = submit(formData)
init(formData, 'ip_exception')
</script>
