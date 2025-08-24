// 商品基本信息
export interface basic {
    type: number
    title: string
    keywords: string
    subtitle: string
    images: Array<string>
    video: string
    brand_id: number|null
    category_ids: Array<number>
    service_ids: Array<number>
    tag_ids:Array<number>
    unit: string // 商品单位
    virtual_sales: number // 虚拟销量
    sort: number // 排序
    is_available: number // 是否上架:1=立即上架,2=放入仓库
    is_schedule: number // 定时上架:1=是,2=否、
    schedule_time: number|null
}

// 商品 SKU 信息
export interface sku {
    images: string|Array<string>
    product_no: string
    price: number
    list_price: number
    cost_price: number
    weight: number
    volume: number // 体积
    stock: number
    alert_stock: number
}

// 单规格信息
export interface specification {
    price: number
    product_no: string
    list_price: number
    cost_price: number
    weight: number
    volume: number // 体积
    stock: number
    alert_stock: number
}

// 规格值
interface specValue {
    value: string
    key: number
}

// 规格
interface spec {
name: string
key: number
values: Array<specValue>
}

// 多规格库存
export interface specifications {
    is_specifications:number // 是否多规格:1=是,2=否
    specs:Array<spec>
    skus:Array<sku>
    sku: specification
}

// 商品信息
export interface info {
    content: string // 内容
}

// 运费配置
export interface ship {
    ship_type: number // 运费类型
    ship_fee: number|null // 运费
    ship_template_id: number|null // 运费模版
}

// 高级配置
export interface param {
    key: any
    value: any
}
export interface config {
    params: Array<param>
    is_show_list_price: number,
    is_show_virtual_sales: number
    is_show_cost_price: number
}
