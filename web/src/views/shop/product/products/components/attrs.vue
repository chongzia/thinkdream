<template>
  <div>
    <div class="flex gap-2">
      <div>批量操作:</div>
      <div class="flex gap-x-2">
        <div class="text-indigo-500 cursor-pointer" v-for="(sku, key) in skus" :key="key">
          <el-popover :visible="sku.visible" placement="top" :width="180">
            <div class="mt-3">
              <el-input-number :min="1" controls-position="right" v-model="sku.init" :precision="2" :step="0.1" />
            </div>
            <div class="flex justify-end mt-5">
              <el-button size="small" text @click="sku.visible = false">取消</el-button>
              <el-button size="small" type="primary" @click="confirmMulti(sku)">确认</el-button>
            </div>
            <template #reference>
              <el-button @click="sku.visible = true">{{ sku.label }}</el-button>
            </template>
          </el-popover>
        </div>
      </div>
    </div>
    <el-table :data="modelValue" class="w-full mt-3" border max-height="600">
      <el-table-column label="规格">
        <el-table-column :prop="item.prop" :label="item.label" v-for="(item, key) in specColumns" :key="key" />
      </el-table-column>
      <el-table-column prop="images" label="SKU图片">
        <template #default="scope">
          <AttachUpload v-model="scope.row.images" name="images" :multi="true" :image-width="12" />
        </template>
      </el-table-column>
      <el-table-column prop="price" label="价格">
        <template #default="scope">
          <el-input-number v-model="scope.row.price" :min="0" controls-position="right" :precision="2" :step="0.1" size="small" />
        </template>
      </el-table-column>
      <el-table-column prop="list_price" label="划线价格">
        <template #default="scope">
          <el-input-number v-model="scope.row.list_price" :min="0" controls-position="right" :precision="2" :step="0.1" size="small" />
        </template>
      </el-table-column>
      <el-table-column prop="cost_price" label="成本价">
        <template #default="scope">
          <el-input-number v-model="scope.row.cost_price" :min="0" controls-position="right" :precision="2" :step="0.1" size="small" />
        </template>
      </el-table-column>
      <el-table-column prop="weight" label="重量">
        <template #default="scope">
          <el-input-number v-model="scope.row.weight" :min="0" controls-position="right" :precision="2" :step="0.1" size="small" />
        </template>
      </el-table-column>
      <el-table-column prop="volume" label="体积">
        <template #default="scope">
          <el-input-number v-model="scope.row.volume" :min="0" controls-position="right" :precision="2" :step="0.1" size="small" />
        </template>
      </el-table-column>
      <el-table-column prop="stock" label="库存">
        <template #default="scope">
          <el-input-number v-model="scope.row.stock" :min="0" controls-position="right" size="small" />
        </template>
      </el-table-column>
      <el-table-column prop="alert_stock" label="库存预警">
        <template #default="scope">
          <el-input-number v-model="scope.row.alert_stock" :min="0" controls-position="right" size="small" />
        </template>
      </el-table-column>
      <el-table-column prop="product_no" label="商品编码">
        <template #default="scope">
          <el-input v-model="scope.row.product_no" placeholder="请输入商品编码" size="large" />
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue'
// @ts-nocheck
interface specColumn {
  label: string
  prop: string
}
const props = defineProps({
  specColumns: {
    type: Array<specColumn>,
    default: []
  },
  specs: {
    type: Array<Object>,
    default: []
  },
  modelValue: {
    type: Array<any>,
    default: []
  },
  tmpId: {
    type: Number,
    default: 0
  },
  isUpdate: {
    type: Boolean,
    default: false
  }
})

const data = ref<Array<any>>([])
const emits = defineEmits(['update:modelValue'])

const initSkus = () => {
  return [
    {
      label: '价格',
      prop: 'price',
      visible: false,
      init: 0
    },
    {
      label: '划线价',
      prop: 'list_price',
      visible: false,
      init: 0
    },
    {
      label: '成本价',
      prop: 'cost_price',
      visible: false,
      init: 0
    },
    {
      label: '重量',
      prop: 'weight',
      visible: false,
      init: 0
    },
    {
      label: '体积',
      prop: 'volume',
      visible: false,
      init: 0
    },
    {
      label: '库存',
      prop: 'stock',
      visible: false,
      init: 0
    },
    {
      label: '库存预警',
      prop: 'alert_stock',
      visible: false,
      init: 0
    }
  ]
}
const skus = ref(initSkus())

// 提交批量操作
const confirmMulti = (sku: any) => {
  data.value = props.modelValue.map(v => {
    v[sku.prop] = sku.init
    return v
  })
  emits('update:modelValue', data.value)
  sku.visible = false
}

// 批量设置
const multiSetSku = (data: Array<any>) => {
  const skuMap = new Map()
  skus.value.forEach((sku: any) => {
    skuMap.set(sku.prop, sku.init)
  })
  console.log(data)
  return data.map(v => {
    for (const key in v) {
      if (skuMap.has(key)) {
        v[key] = skuMap.get(key)
      }
    }

    return v
  })
}
// 更新的时候不允许切换
// 监听模版切换
if (!props.isUpdate) {
  watch(
    () => props.tmpId,
    () => {
      skus.value = initSkus()
      data.value = multiSetSku(props.modelValue)
      emits('update:modelValue', data.value)
    },
    { immediate: true }
  )
}

// 监听 modelValue 更新modelValue
watch(
  props.modelValue,
  (newVal, oldVal) => {
    emits('update:modelValue', newVal)
  },
  { immediate: true }
)
</script>
