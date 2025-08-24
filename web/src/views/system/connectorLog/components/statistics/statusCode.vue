<template>
  <v-chart class="h-[400px] w-full" autoresize :option="_statusCodes" />
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { useQuery } from './query'

const { statusCodes, getStatusCodes } = useQuery()
getStatusCodes()
const _statusCodes = ref({
  title: {
    text: '请求状态码',
    left: 'center'
  },
  tooltip: {
    trigger: 'item',
    formatter: '{a} <br/>{b} : {c} ({d}%)'
  },
  legend: {
    orient: 'vertical',
    left: 'left'
  },
  series: [
    {
      name: '请求状态码',
      type: 'pie',
      radius: '55%',
      center: ['50%', '60%'],
      data: statusCodes,
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }
  ]
})
</script>
