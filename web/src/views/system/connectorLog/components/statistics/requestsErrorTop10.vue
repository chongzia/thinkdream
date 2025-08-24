<template>
  <v-chart class="h-[400px] w-full" autoresize :option="requests" />
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { useQuery } from './query'

const { requestErrorsPathes, requestErrorsCount, getMaxRequestErrorsTop10 } = useQuery()
getMaxRequestErrorsTop10()

const requests = ref({
  title: {
    text: '请求接口错误Top10'
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
    data: requestErrorsPathes
  },
  series: [
    {
      name: '请求接口',
      type: 'bar',
      data: requestErrorsCount
    }
  ]
})
</script>
