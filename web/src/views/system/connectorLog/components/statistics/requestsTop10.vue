<template>
  <v-chart class="h-[400px] w-full" autoresize :option="requests" />
</template>
<script lang="ts" setup>
import { ref } from 'vue'

import { useQuery } from './query'

const { requestsPathes, requestsCount, getMaxRequestTop10 } = useQuery()
getMaxRequestTop10()

const requests = ref({
  title: {
    text: '最多请求接口Top10'
  },
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'shadow'
    }
  },
  legend: {},
  grid: {
    left: '3%',
    right: '4%',
    bottom: '3%',
    containLabel: true
  },
  xAxis: {
    type: 'value',
    boundaryGap: [0, 0.01]
  },
  yAxis: {
    type: 'category',
    inverse: true,
    data: requestsPathes
  },
  series: [
    {
      name: '请求接口',
      type: 'bar',
      data: requestsCount
    }
  ]
})
</script>
