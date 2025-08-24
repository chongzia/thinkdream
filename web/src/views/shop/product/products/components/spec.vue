<template>
  <el-form :model="specifications" label-width="130px" ref="form" class="min-h-[60rem]">
    <el-form-item label="启用多规格" prop="is_specifications">
      <el-switch v-model="specifications.is_specifications" size="large" :active-value="2" :inactive-value="1" v-if="id" disabled />
      <el-switch v-model="specifications.is_specifications" size="large" :active-value="2" :inactive-value="1" v-else />
    </el-form-item>
    <!--多规格属性-->
    <div v-if="specifications.is_specifications === 2">
      <div class="w-2/3">
        <!-- 选择规格模版 -->
        <el-form-item label="规格模版" prop="spec_id" v-if="!id">
          <el-select v-model="tmpId" class="m-2" placeholder="请选择规格模版" size="large" @change="selectTmp" clearable>
            <el-option v-for="spec in specsData" :key="spec.id" :label="spec.name" :value="spec.id" />
          </el-select>
        </el-form-item>
        <el-form-item label="模版规格">
          <div class="flex justify-between w-full">
            <el-button @click="addSpec" type="primary">新增规格</el-button>
            <!--<el-button plain bg @click="generateSpecs">生成属性</el-button>-->
          </div>
          <el-table :data="specs" border class="mt-3">
            <el-table-column label="规格名称" width="200" prop="name">
              <template #default="scope">
                <el-input v-model="scope.row.name" name="name" clearable placeholder="请输入规格名称" />
              </template>
            </el-table-column>
            <el-table-column label="规格值" prop="specValues">
              <template #default="scope">
                <div class="grid grid-cols-4 gap-x-1 gap-y-2">
                  <div v-for="specValue in scope.row.values" :key="specValue" class="flex w-48">
                    <el-input name="name" clearable v-model="specValue.value" placeholder="请输入规格值" />
                    <div class="flex h-6 pt-1 pl-1 w-14">
                      <Icon name="trash" className="w-5 h-5 ml-1 text-red-600 cursor-pointer" @click="destroySpecValue(scope.row.key, specValue.key)" />
                    </div>
                  </div>
                  <div class="flex items-center justify-center w-12 cursor-pointer" @click="addSpecValue(scope.row.key)">
                    <Icon name="plus" className="w-4 h-4 mr-1 text-indigo-600" />
                    <span class="text-indigo-600">新增</span>
                  </div>
                </div>
              </template>
            </el-table-column>
            <el-table-column label="操作" width="60">
              <template #default="scope">
                <Icon name="trash" className="w-5 h-5 text-red-600" @click="destroySpec(scope.row.key)" />
              </template>
            </el-table-column>
            <template #empty> 暂无规格 去 <el-button @click="addSpec" type="primary" plain size="small">新增</el-button> </template>
          </el-table>
        </el-form-item>
      </div>
      <div>
        <!-- 生成规格属性 -->
        <el-form-item label="规格属性" v-if="specColumns.length" class="w-full">
          <div class="w-full">
            <attrs :spec-columns="specColumns" v-model="productAttrs" :tmp-id="tmpId" :specs="specs" :is-update="!!id" />
          </div>
        </el-form-item>
      </div>
    </div>
    <!--单规格属性 -->
    <div v-if="specifications.is_specifications === 1" class="w-1/3">
      <el-form-item
        label="销售价"
        prop="sku.price"
        :rules="[
          {
            required: true,
            message: '销售价'
          }
        ]"
      >
        <el-input-number v-model="specifications.sku.price" :min="1" controls-position="right" size="large" :precision="2" :step="0.1" />
      </el-form-item>
      <el-form-item label="划线价" prop="sku.list_price">
        <el-input-number v-model="specifications.sku.list_price" :min="1" controls-position="right" size="large" :precision="2" :step="0.1" />
      </el-form-item>
      <el-form-item label="成本价" prop="sku.cost_price">
        <el-input-number v-model="specifications.sku.cost_price" :min="1" controls-position="right" size="large" :precision="2" :step="0.1" />
      </el-form-item>

      <el-form-item label="重量(KG)" prop="sku.weight">
        <el-input-number v-model="specifications.sku.weight" :min="1" controls-position="right" size="large" :precision="2" :step="0.1" />
      </el-form-item>
      <el-form-item label="体积(m³)" prop="sku.volume">
        <el-input-number v-model="specifications.sku.volume" :min="1" controls-position="right" size="large" :precision="2" :step="0.1" />
      </el-form-item>
      <el-form-item label="库存" prop="sku.stock">
        <el-input-number v-model="specifications.sku.stock" :min="1" controls-position="right" size="large" />
      </el-form-item>
      <el-form-item label="库存预警" prop="sku.alert_stock">
        <el-input-number v-model="specifications.sku.alert_stock" :min="1" controls-position="right" size="large" />
      </el-form-item>
      <el-form-item label="商品编码" prop="sku.product_no">
        <el-input v-model="specifications.sku.product_no" placeholder="请输入商品编码" size="large" />
      </el-form-item>
    </div>
  </el-form>
</template>
<script lang="ts" setup>
// 商品基本信息
import http from '@/support/http'
import { useProductStore } from '../store'
import { reactive, ref, onMounted, watch, toRaw } from 'vue'
import attrs from './attrs.vue'
import { useFormSubmit } from './useFormSubmit'
import router from '@/router'

const props = defineProps({
  next: {
    type: Function,
    default: null
  }
})

const productStore = useProductStore()
const specifications = reactive(productStore.getSpecifications)

const specsData = ref()
const tmpId = ref()
const specs = ref(specifications.specs)
// 编辑页面
const id = ref()
id.value = router.currentRoute.value.params.id

const getSpecsTmp = () => {
  http.get('/shop/product/spec/tmp', { limit: 1000 }).then(r => {
    specsData.value = r.data.data
  })
}

// 选择规格模版
const selectTmp = (v: any) => {
  specs.value = []
  specsData.value.forEach((item: any) => {
    if (item.id === v) {
      for (let i = 0; i < item.specs.length; i++) {
        const values = []
        for (let j = 0; j < item.specs[i].values.length; j++) {
          values.push({
            value: item.specs[i].values[j].value,
            key: j
          })
        }
        specs.value.push({
          name: item.specs[i].name as string,
          key: i,
          values
        })
      }
    }
  })
}

// 新增规格
const addSpec = () => {
  specs.value.push({
    name: '',
    key: specs.value.length,
    values: [{ value: '', key: 0 }]
  })
}

// 添加规格值
const addSpecValue = (key: any) => {
  specs.value[key].values.push({ value: '', key: specs.value[key].values.length })
}

// 删除规格值
const destroySpecValue = (key: any, index: any) => {
  specs.value[key].values = specs.value[key].values.filter(item => {
    return item.key !== index
  })
}

// 删除规格
const destroySpec = (key: any) => {
  specs.value = specs.value.filter(item => {
    return item.key !== key
  })
}

const productAttrs = ref<Array<any>>(specifications.skus)
const specColumns = ref<Array<any>>([])

// 监听规格变化
watch(
  specs,
  () => {
    getSpecColumns()
    getProductAttrs()
  },
  { deep: true }
)

// 获得规格栏目
const getSpecColumns = () => {
  specColumns.value = []
  for (let i = 0; i < specs.value.length; i++) {
    specColumns.value.push({
      // 用 s_ 开头，后台可以区分是规格 name
      prop: 's_' + specs.value[i].name,
      label: specs.value[i].name
    })
  }
}
const getAttrs = () => {
  const values: Array<any> = specs.value
    .filter(item => {
      return item.values.length > 0
    })
    .map(item => {
      return item.values
    })
  const length = values.length
  if (length === 0) {
    return []
  }

  let attrs: any = []
  if (length === 1) {
    values[0].forEach((v: any) => {
      attrs.push([v.value])
    })
  } else {
    attrs = values.reduce((a, b) => {
      const arr: any = []
      a.forEach((v: any) => {
        b.forEach((val: any) => {
          arr.push(v instanceof Array ? [...v, val.value] : [v.value, val.value])
        })
      })
      return arr
    })
  }

  return attrs
}
// 规格临时变量
// 编辑的时候初始化
const specTmps: Array<any> = []
if (id.value) {
  if (productAttrs.value.length > 0) {
    specifications.skus.forEach((item: any) => {
      // 解构 让对象失去响应之后进行初始化
      specTmps.push({ ...toRaw(item) })
    })
  }
}
// 计算产品属性
const getProductAttrs = () => {
  productAttrs.value = []
  if (specTmps.length > 0) {
    specTmps.forEach((item: any) => {
      productAttrs.value.push(item)
    })
    specTmps.splice(0, specTmps.length)
  } else {
    const attrs = getAttrs()
    attrs.forEach((item: any) => {
      const attr: any = {
        images: null,
        product_no: '',
        price: 0,
        list_price: 0,
        cost_price: 0,
        weight: 0,
        volume: 0, // 体积
        stock: 0,
        alert_stock: 0
      }
      for (let i = 0; i < item.length; i++) {
        attr[specColumns.value[i].prop] = item[i]
      }
      productAttrs.value.push(attr)
    })
  }
}

// 编辑页面从后台获取规格数据
if (id.value) {
  getSpecColumns()
  getProductAttrs()
}

// 保留
const { form, submit } = useFormSubmit(props.next)
defineExpose({ submit })

// 更新多规格信息
watch(
  () => productAttrs.value,
  () => {
    console.log(productAttrs.value)
    productStore.setSpecifications({
      is_specifications: specifications.is_specifications,
      sku: specifications.sku,
      skus: productAttrs.value,
      specs: specs.value
    })
  },
  { deep: true }
)
onMounted(() => {
  // 非编辑的时候获取规格模版
  if (!id.value) {
    getSpecsTmp()
  }
})
</script>
