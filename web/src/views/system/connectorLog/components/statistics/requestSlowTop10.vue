<template>
  <v-chart class="h-[400px] w-full" autoresize :option="requests" />
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { useQuery } from './query'

const { requestSlowPathes, requestSlowCount, getSlowRequestTop10 } = useQuery()
getSlowRequestTop10()

const requests = ref({
  title: {
    text: '请求接口最慢Top10'
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
    formatter: '{value} ms',
    data: requestSlowPathes
  },
  series: [
    {
      name: '请求接口时间(ms)',
      type: 'bar',
      data: requestSlowCount
    }
  ]
})
</script>
