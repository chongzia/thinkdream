export interface style {
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
export interface component {
  name: string
  title?: string
  icon: string
  active: boolean
  background_color?: string
  data?: Array<any> | string | number | Object
  style: style
}

// swiper
export interface swiperComponent {
  name: string
  title: string
  icon: string
  active: boolean
  data: Array<{ title: string; image: string; url: string }>
  style: {
    border_radius: number
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
    indicator: {
      is_show: boolean
      active_color: string
      inactive_color: string
      position: 'bottom' | 'left' | 'right'
      mode: 'line' | 'dot'
      radius: number
    }
  }
}

// search
export interface searchComponent {
  name: string
  title: string
  icon: string
  active: boolean
  placeholder: string
  style: {
    color: string
    size: number
    position: 'left' | 'center' | 'right'
    border_radius: number
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
  }
}

// 导航组件
export interface NavComponent {
  name: string
  title: string
  active: boolean
  icon: string
  data: Array<{ title: string; icon: string; url: string }>
  style: {
    shape: 'square' | 'circle'
    color: string
    rows: number
    cols: number
    size: number
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
  }
}

// 图片魔方
export interface ImagesComponent {
  name: string
  title: string
  active: boolean
  icon: string
  data: Array<{ image: string; url: string }>
  style: {
    type: number
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
  }
}

// 公告
export interface AnnounceComponent {
  name: string
  title: string
  active: boolean
  type: 'vertical' | 'level'
  icon: string
  logo: string
  data: Array<{ title: string; url: string }>
  style: {
    color: string
    size: number
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
  }
}

// 标题组件
export interface TitleComponent {
  name: string
  title: string
  active: boolean
  icon: string
  data: { title: string; url: string }
  style: {
    color: string
    size: number
    position: 'left' | 'center' | 'right'
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
  }
}

// 商品组件
export interface GoodsComponent {
  name: string
  title: string
  active: boolean
  icon: string
  data: Array<{ id: number; title: number; images: Array<string>; price: number; list_price: number }>
  category_ids: Array<number> | null
  goods_number: number
  sort: 'all' | 'sales' | 'price'
  is_show_price: boolean // 价格
  is_show_list_price: boolean // 原价
  is_show_title: boolean // 展示标题
  is_show_coupon: boolean // 是否展示优惠卷
  style: {
    price_color: string
    cols: number
    background_color: string
    pl: number
    pr: number
    pt: number
    pb: number
  }
}

// 商品分类
export interface CategoryComponent {
  name: string
  title: string
  active: boolean
  icon: string
  style: {
    color: string
    background_color_start: string
    background_color_end: string
    pl: number
    pr: number
    pt: number
    pb: number
  }
}
// swiper 组件
export const swiper = {
  name: 'swiper',
  title: '轮播图',
  active: false,
  icon: 'photo',
  data: [],
  style: {
    border_radius: 4,
    background_color: '',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0,
    // 指示器
    indicator: {
      is_show: true,
      active_color: '#FFFFFF',
      inactive_color: 'rgba(255, 255, 255, 0.35)',
      position: 'bottom',
      mode: 'line'
    }
  }
}

export const search: searchComponent = {
  name: 'search',
  title: '搜索',
  active: false,
  icon: 'magnifying-glass',
  placeholder: '',
  style: {
    color: '',
    position: 'left',
    size: 13,
    border_radius: 0,
    background_color: '',
    pl: 2,
    pr: 2,
    pt: 2,
    pb: 2
  }
}

export const nav: NavComponent = {
  name: 'nav',
  title: '导航',
  active: false,
  icon: 'paper-airplane',
  data: [],
  style: {
    shape: 'square',
    color: '',
    rows: 3,
    cols: 2,
    size: 13,
    background_color: '',
    pl: 2,
    pr: 2,
    pt: 2,
    pb: 2
  }
}

// 图片魔方
export const images: ImagesComponent = {
  name: 'images',
  title: '图片魔方',
  active: false,
  icon: 'squares-plus',
  data: [],
  style: {
    type: 1,
    background_color: '',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0
  }
}

// 公告
export const announces: AnnounceComponent = {
  name: 'announce',
  title: '公告',
  active: false,
  type: 'level',
  icon: 'speaker-wave',
  logo: '',
  data: [],
  style: {
    color: '',
    size: 12,
    background_color: '',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0
  }
}

// 标题
export const title: TitleComponent = {
  name: 'title',
  title: '标题',
  active: false,
  icon: 'language',
  data: { title: '', url: '' },
  style: {
    color: '',
    size: 18,
    position: 'left',
    background_color: '',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0
  }
}

// 商品
export const goods: GoodsComponent = {
  name: 'goods',
  title: '商品列表',
  active: false,
  icon: 'shopping-cart',
  data: [],
  category_ids: null,
  goods_number: 2,
  sort: 'all',
  is_show_title: true,
  is_show_price: true,
  is_show_list_price: true,
  is_show_coupon: true,
  style: {
    price_color: '',
    cols: 2,
    background_color: '',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0
  }
}

// 分类组件
export const category: CategoryComponent = {
  name: 'category',
  title: '商品分类',
  active: false,
  icon: 'list-bullet',
  style: {
    color: '',
    background_color_start: 'rgb(237, 13, 13)',
    background_color_end: 'rgb(92, 3, 3)',
    pl: 0,
    pr: 0,
    pt: 0,
    pb: 0
  }
}
export const basicComponents = [{ ...swiper }, { ...search }, { ...nav }, { ...images }, { ...announces }, { ...title }, { ...goods }, { ...category }]
