<template>
  <div class="grid grid-cols-1 gap-y-2 md:gap-y-0 md:grid-cols-4 gap-x-4">
    <el-card class="rounded-md" shadow="hover" v-for="(item, key) in basic" :key="key">
      <div class="grid gap-y-2">
        <div class="text-2xl font-bold text-center">{{ item.count }}</div>
        <div class="mt-5 text-center text-md">{{ item.title }}</div>
      </div>
    </el-card>
  </div>
</template>
<script setup lang="ts">
import http from '@/support/http'
import { onMounted, ref } from 'vue'

const basic = ref([
  { title: '请求总量', count: 0 },
  { title: '平均请求时间(ms)', count: 0 },
  { title: '错误率', count: 0 },
  { title: '接口总数', count: 0 }
])

const summaryRequest = () => {
  http.get('system/connector/summary').then(r => {
    const res = r.data.data
    basic.value[0].count = res.total
    basic.value[1].count = res.average_time
    basic.value[2].count = res.incorrect_rate
    basic.value[3].count = res.api_count
  })
}
onMounted(() => {
  summaryRequest()
})
</script>
