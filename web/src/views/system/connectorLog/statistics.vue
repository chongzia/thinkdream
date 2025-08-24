<template>
  <div class="grid px-5 py-3 bg-white gap-y-3 dark:bg-regal-dark">
    <div class="flex mt-2 gap-x-3">
      <el-radio-group v-model="timeRange">
        <el-radio-button :label="item.label" :value="item.value" v-for="item in timeRanges" :key="item.value" />
      </el-radio-group>
    </div>
    <Basic />
    <div class="flex flex-col mt-10 gap-y-10">
      <div class="flex justify-between w-full">
        <div class="w-full"><StatusCode :key="componentKey" /></div>
        <div class="w-full"><RequestTimeToken :key="componentKey" /></div>
      </div>
      <div class="flex justify-between">
        <div class="w-full"><RequestTop10 :key="componentKey" /></div>
        <div class="w-full"><RequestsErrorTop10 :key="componentKey" /></div>
      </div>
      <div class="flex justify-between">
        <div class="w-full"><RequestFastTop10 :key="componentKey" /></div>
        <div class="w-full"><RequestSlowTop10 :key="componentKey" /></div>
      </div>
    </div>

    <div class="w-full mt-10">
      <EveryMinuteRequests />
      <EveryHourRequests />
    </div>
  </div>
</template>
<script lang="ts" setup>
import Basic from './components/statistics/basic.vue'
import { useQuery } from './components/statistics/query'
import StatusCode from './components/statistics/statusCode.vue'
import RequestTimeToken from './components/statistics/requestTimeTaken.vue'
import RequestTop10 from './components/statistics/requestsTop10.vue'
import RequestsErrorTop10 from './components/statistics/requestsErrorTop10.vue'
import RequestFastTop10 from './components/statistics/requestFastTop10.vue'
import RequestSlowTop10 from './components/statistics/requestSlowTop10.vue'
import EveryMinuteRequests from './components/statistics/everyMinuteRequests.vue'
import EveryHourRequests from './components/statistics/everyHourRequests.vue'
import { ref, watch } from 'vue'
import { useTimeStore } from './components/statistics/timeStore'

const { timeRange } = useQuery()
const componentKey = ref(0)

const timeRanges = [
  {
    label: '15分钟',
    value: 60 * 15
  },
  {
    label: '30分钟',
    value: 60 * 30
  },
  {
    label: '1小时',
    value: 60 * 60
  },
  {
    label: '5小时',
    value: 3600 * 5
  },
  {
    label: '12小时',
    value: 3600 * 12
  },
  {
    label: '24小时',
    value: 3600 * 24
  },
  {
    label: '2天',
    value: 3600 * 24 * 2
  },
  {
    label: '5天',
    value: 3600 * 24 * 5
  },
  {
    label: '1周',
    value: 3600 * 24 * 7
  }
]

const timeStore = useTimeStore()

watch(
  () => timeRange.value,
  () => {
    timeStore.setTimeRange(timeRange.value)
    componentKey.value += 1
  }
)
</script>
