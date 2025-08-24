import { defineStore } from 'pinia'

interface component {
  name: string
  title?: string
  background_color?: string
  data?: Array<any> | string | number | Object
  style: {
    border_color: string // 边框颜色
    border_radius: string
    border_shadow: string
    is_show_background_color: boolean
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
    space: string | number
  }
}

const swiper: component = {
  name: 'swiper',
  title: '轮播图',
  data: Array<{ image: string; url: string }>,
  style: {
    border_color: '',
    border_radius: '',
    border_shadow: '',
    is_show_background_color: false,
    background_color: '',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0,
    space: ''
  }
}

const search: component = {
  name: '',
  style: {
    border_color: '',
    border_radius: '',
    border_shadow: '',
    is_show_background_color: false,
    background_color: '',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0,
    space: ''
  }
}
export const useDiyStore = defineStore('diyStore', {
  state: () => {
    return {
      swiper: { ...swiper },
      search: { ...search }
    }
  },

  getters: {
    getSwiper(): component {
      return this.swiper
    },
    getSearch(): component {
      return this.search
    }
  }
})
