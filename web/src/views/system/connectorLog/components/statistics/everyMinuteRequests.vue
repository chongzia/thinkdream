<template>
  <v-chart class="h-[400px]" autoresize :option="requests" />

  <v-chart class="h-[400px]" autoresize :option="requestsTimeTaken" />
</template>
<script lang="ts" setup>
import http from '@/support/http'
import { ref } from 'vue'

// 每分钟请求数量
const requests = ref({
  title: {
    text: '接口每分钟请求数量'
  },
  xAxis: {
    data: []
  },
  yAxis: {
    name: '每分钟请求数量'
  },
  series: [
    {
      data: [],
      type: 'line',
      stack: 'x'
    }
  ]
})

// 每分钟平均请求时间
const requestsTimeTaken = ref({
  title: {
    text: '接口每分钟请求平均时间(ms)'
  },
  xAxis: {
    data: []
  },
  yAxis: {
    name: '接口每分钟请求平均时间(ms)'
  },
  series: [
    {
      data: [],
      type: 'line',
      stack: 'x'
    }
  ]
})

http.get('system/connector/requests/every/minute').then(r => {
  const data = r.data.data
  // 每分钟请求数量
  requests.value.xAxis.data = data.minutes
  requests.value.series[0].data = data.count
  // 每分钟请求时间
  requestsTimeTaken.value.xAxis.data = data.minutes
  requestsTimeTaken.value.series[0].data = data.time_taken
})
</script>
