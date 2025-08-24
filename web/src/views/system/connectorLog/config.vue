<template>
  <div class="px-5 py-3 bg-white dark:bg-regal-dark">
    <el-alert title="推送通知在 「系统管理 > webhook 通知」中配置" type="success" />
    <div class="mt-2">
      <el-tabs v-model="activeName">
        <el-tab-pane label="响应超时监控" name="response">
          <Timeout />
        </el-tab-pane>
        <el-tab-pane label="请求错误监控" name="request">
          <RequestError />
        </el-tab-pane>
        <el-tab-pane label="IP异常监控" name="ip">
          <IpException />
        </el-tab-pane>
        <el-tab-pane label="请求量监控" name="requests">
          <Requests />
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import Timeout from './components/timeout.vue'
import RequestError from './components/requestError.vue'
import IpException from './components/ipException.vue'
import Requests from './components/requests.vue'

const activeName = ref('response')
</script>
