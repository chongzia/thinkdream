import { defineStore } from 'pinia'

export const useTimeStore = defineStore('connect_statistics_timerange', {
  state: () => {
    return {
      timeRange: 15 * 60
    }
  },
  getters: {
    getTimeRange(): number {
      return this.timeRange
    }
  },
  actions: {
    setTimeRange(time: number) {
      this.timeRange = time
    }
  }
})
