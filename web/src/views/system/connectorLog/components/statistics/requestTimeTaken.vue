<template>
  <v-chart class="h-[400px] w-full" autoresize :option="requestTimeTaken" />
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { useQuery } from './query'

const { timeToken, getTimeTaken } = useQuery()
getTimeTaken()

const requestTimeTaken = ref({
  title: {
    text: '请求处理时间(ms)',
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
      name: '请求处理时间(ms)',
      type: 'pie',
      radius: '55%',
      center: ['50%', '60%'],
      data: timeToken,
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
