import { defineStore } from 'pinia'
import { basic, specifications, info, ship, config } from './product'

interface product {
    id: any
    basic: basic
    specifications: specifications
    info: info,
    ship: ship,
    config:config
}

const init:product = {
  id: null,
  basic: {
    type: 1,
    title: '',
    keywords: '',
    subtitle: '',
    images: [],
    video: '',
    brand_id: null,
    category_ids: [],
    service_ids: [],
    tag_ids: [],
    is_available: 1,
    is_schedule: 2,
    schedule_time: null,
    unit: '',
    virtual_sales: 0,
    sort: 1
  },
  specifications: {
    is_specifications: 1,
    specs: [],
    skus: [],
    sku: {
      product_no: '',
      price: 0,
      list_price: 0,
      cost_price: 0,
      weight: 0,
      volume: 0,
      stock: 0,
      alert_stock: 0
    }
  },
  info: {
    content: ''
  },
  ship: {
    ship_type: 1,
    ship_fee: 0,
    ship_template_id: null
  },
  config: {
    params: [],
    is_show_list_price: 1,
    is_show_virtual_sales: 1,
    is_show_cost_price: 1
  }
}

export const useProductStore = defineStore('productStore', {
  // 初始化
  state: ():product => {
    return { ...init }
  },

  // 获取
  getters: {
    getProduct(): product {
      return {
        id: null,
        basic: this.basic,
        specifications: this.specifications,
        info: this.info,
        ship: this.ship,
        config: this.config
      }
    },
    getBasic():basic {
      return this.basic
    },
    getSpecifications():specifications {
      return this.specifications
    },
    getInfo():info {
      return this.info
    },
    getShip():ship {
      return this.ship
    },
    getConfig():config {
      return this.config
    }
  },

  // 操作
  actions: {
    setBasic(basic: basic) {
      this.basic = basic
    },
    setSpecifications(specifications: specifications) {
      this.specifications = specifications
    },
    setInfo(info: info) {
      this.info = info
    },
    setId(id: any) {
      this.id = id
    },
    initProduct() {
      this.$reset()
    }
  }
})
