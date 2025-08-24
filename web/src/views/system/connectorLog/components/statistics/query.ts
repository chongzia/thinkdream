import http from '@/support/http'
import { ref } from 'vue'
import { useTimeStore } from './timeStore'

export const useQuery = () => {
  const timeStore = useTimeStore()
  const timeRange = ref(timeStore.timeRange)

  // 请求状态码数据
  const statusCodes = ref([])
  // 请求消耗时间数据数据
  const timeToken = ref([])
  // 请求最多的数据
  const requestsPathes = ref([])
  const requestsCount = ref([])
  // 请求错误最多数据
  const requestErrorsPathes = ref([])
  const requestErrorsCount = ref([])
  // 请求最快的数据
  const requestFastPathes = ref([])
  const requestFastCount = ref([])
  // 请求最慢的数据
  const requestSlowPathes = ref([])
  const requestSlowCount = ref([])

  // 获取状态码
  const getStatusCodes = () => {
    http.get('system/connector/status/code', { time: timeStore.getTimeRange }).then(r => {
      statusCodes.value = r.data.data
    })
  }

  // 获取消耗时间
  const getTimeTaken = () => {
    http.get('system/connector/time/taken', { time: timeStore.getTimeRange }).then(r => {
      timeToken.value = r.data.data
    })
  }

  // 获取最多请求 top10
  const getMaxRequestTop10 = () => {
    http.get('system/connector/requests/top10', { time: timeStore.getTimeRange }).then(r => {
      requestsPathes.value = r.data.data.pathes
      requestsCount.value = r.data.data.count
    })
  }
  // 获取请求错误 top10
  const getMaxRequestErrorsTop10 = () => {
    http.get('system/connector/requests/errors/top10', { time: timeStore.getTimeRange }).then(r => {
      requestErrorsPathes.value = r.data.data.pathes
      requestErrorsCount.value = r.data.data.count
    })
  }
  // 获取最快请求 top10
  const getFastRequestTop10 = () => {
    http.get('system/connector/requests/fast/top10', { time: timeStore.getTimeRange }).then(r => {
      requestFastPathes.value = r.data.data.pathes
      requestFastCount.value = r.data.data.count
    })
  }
  // 获取最慢请求 top10
  const getSlowRequestTop10 = () => {
    http.get('system/connector/requests/slow/top10', { time: timeStore.getTimeRange }).then(r => {
      requestSlowPathes.value = r.data.data.pathes
      requestSlowCount.value = r.data.data.count
    })
  }

  return {
    timeRange,
    statusCodes,
    timeToken,
    requestsPathes,
    requestsCount,
    requestErrorsPathes,
    requestErrorsCount,
    requestFastCount,
    requestFastPathes,
    requestSlowPathes,
    requestSlowCount,
    getStatusCodes,
    getTimeTaken,
    getMaxRequestTop10,
    getMaxRequestErrorsTop10,
    getFastRequestTop10,
    getSlowRequestTop10
  }
}
