<template>
  <div class="w-full">
    <el-row :gutter="16" class="search-form-row">
      <template v-for="(item, k) in fields" :key="k">
        <el-col 
          v-show="item.show && (k < 4 || expand)"
          :xs="getColSpan(item, 'xs')"
          :sm="getColSpan(item, 'sm')"
          :md="getColSpan(item, 'md')"
          :lg="getColSpan(item, 'lg')"
          :xl="getColSpan(item, 'xl')"
          :xxl="getColSpan(item, 'xxl')"
          class="search-form-item"
        >
          <div class="search-item-wrapper">
            <!-- 普通输入框 -->
            <el-form-item :label="item.label" v-if="item.type === 'input'">
              <el-input :placeholder="item.placeholder" v-model="queryStore.getTableQuery[item.name]" clearable />
            </el-form-item>
            
            <!-- 下拉选择框 -->
            <el-form-item :label="item.label" v-if="item.type === 'select'">
              <Select :api="item.api" :options="item.options" v-model="queryStore.getTableQuery[item.name]" :query="item.query" :placeholder="item.placeholder" />
            </el-form-item>
            
            <!-- 数字输入框 -->
            <el-form-item :label="item.label" v-if="item.type === 'input-number'">
              <el-input-number v-model="queryStore.getTableQuery[item.name]" :placeholder="item.placeholder" clearable class="w-full" />
            </el-form-item>
            
            <!-- 日期选择器 -->
            <el-form-item :label="item.label" v-if="item.type === 'date'">
              <el-date-picker type="date" v-model="queryStore.getTableQuery[item.name]" :placeholder="item.placeholder" clearable value-format="YYYY-MM-DD" class="w-full" />
            </el-form-item>
            
            <!-- 日期时间选择器 -->
            <el-form-item :label="item.label" v-if="item.type === 'datetime'">
              <el-date-picker type="datetime" v-model="queryStore.getTableQuery[item.name]" :placeholder="item.placeholder" clearable value-format="YYYY-MM-DD HH:mm:ss" class="w-full" />
            </el-form-item>
            
            <!-- 树形选择器 -->
            <el-form-item :label="item.label" v-if="item.type === 'tree'">
              <el-tree-select v-model="queryStore.getTableQuery[item.name]" value-key="id" :placeholder="item.placeholder" clearable :data="item.options" check-strictly :props="item.props" class="w-full" />
            </el-form-item>
            
            <!-- 范围选择器 -->
            <div class="range-wrapper" v-if="item.type === 'range'">
              <el-form-item :label="item.label">
                <div class="flex gap-x-2 w-full">
                  <div v-for="(sitem, key) in item.children" :key="key" class="flex-1">
                    <el-input v-model="queryStore.getTableQuery[sitem.name]" :placeholder="sitem.placeholder" v-if="sitem.type === 'input'" clearable />
                    <Select
                      :api="sitem.api"
                      :options="sitem.options"
                      v-model="queryStore.getTableQuery[sitem.name]"
                      :query="sitem.query"
                      :placeholder="sitem.placeholder"
                      clearable
                      v-if="sitem.type === 'select'"
                    />
                    <el-input-number v-model="queryStore.getTableQuery[sitem.name]" :placeholder="sitem.placeholder" v-if="sitem.type === 'input-number'" clearable class="w-full" />
                    <el-date-picker type="date" v-model="queryStore.getTableQuery[sitem.name]" :placeholder="sitem.placeholder" v-if="sitem.type === 'date'" clearable value-format="YYYY-MM-DD" class="w-full" />
                    <el-date-picker
                      type="datetime"
                      v-model="queryStore.getTableQuery[sitem.name]"
                      :placeholder="sitem.placeholder"
                      v-if="sitem.type === 'datetime'"
                      clearable
                      value-format="YYYY-MM-DD HH:mm:ss"
                      class="w-full"
                    />
                  </div>
                </div>
              </el-form-item>
            </div>
          </div>
        </el-col>
      </template>
      
      <!-- 操作按钮区域 -->
      <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" class="search-buttons">
        <div class="flex justify-end items-center gap-2">
          <el-button type="primary" @click="search" :disabled="loading" size="default">
            {{ t('system.search') }}
          </el-button>
          <el-button @click="reset" :disabled="loading" size="default">
            {{ t('system.reset') }}
          </el-button>
          <el-button @click="expandSearch()" v-if="fields.length > 3" text circle size="default">
            <Icon :name="expand ? 'chevron-up' : 'chevron-down'" className="w-4 h-4" />
          </el-button>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script lang="ts" setup>
// @ts-nocheck
import { onMounted, reactive, ref } from 'vue'
import { isBoolean, t } from '@/support/helper'
import { useQueryStore } from './useQueryStore'
type itemType = 'input' | 'select' | 'input-number' | 'date' | 'datetime' | 'range' | 'tree'
interface Option {
  label: string
  value: string | number
}
interface field {
  type: itemType
  label: string
  name: string
  api?: string
  placeholder?: string
  default?: any
  options?: Array<Option>
  children?: Array<field>
  show?: boolean
  props?: Object // 树形 props
  query?: object
}

const props = defineProps({
  fields: {
    type: Array<field>,
    default: () => {
      return []
    }
  },
  loading: {
    type: Boolean,
    default: false
  }
})

const queryStore = useQueryStore()
const emits = defineEmits(['search', 'reset'])
const expand = ref<boolean>(false)
const defaults = {}
const _fields = ref<Array<field>>(props.fields)
_fields.value = _fields.value?.map(field => {
  if (!field.placeholder && field.type !== 'range') {
    field.placeholder = (field.type === 'select' ? '请选择' : '请输入') + field.label
  }
  field.show = isBoolean(field.show) ? field.show : true

  // 填充默认值
  if (field.default) {
    queryStore.getTableQuery[field.name] = field.default
    defaults[field.name] = field.default
  }

  // 填充 range 组建的默认
  if (field.type === 'range' && field.children?.length > 0) {
    field.children?.forEach(item => {
      if (field.default) {
        queryStore.getTableQuery[item.name] = item.default
        defaults[item.name] = item.default
      }
    })
  }
  return reactive(field)
})

const search = () => {
  emits('search')
}

/**
 * 搜索重置
 */
const reset = () => {
  emits('reset')
}

const expandSearch = () => {
  expand.value = !expand.value
}

/**
 * 获取响应式栅格配置
 * @param item 字段项
 * @param breakpoint 断点 (xs|sm|md|lg|xl|xxl)
 * @returns 栅格跨度
 */
const getColSpan = (item: field, breakpoint: string): number => {
  // range 类型组件需要更多空间
  if (item.type === 'range') {
    switch (breakpoint) {
      case 'xs': return 24 // 超小屏占满一行 (1列)
      case 'sm': return 24 // 小屏占满一行 (1列)
      case 'md': return 12 // 中屏占半行 (2列)
      case 'lg': return 8  // 大屏占1/3行 (3列)
      case 'xl': return 6  // 超大屏占1/4行 (4列)
      case 'xxl': return 6 // 超超大屏占1/4行 (4列)
      default: return 24
    }
  }
  
  // 普通组件的响应式配置：1、2、3、4、5、6 列布局
  switch (breakpoint) {
    case 'xs': return 24       // 超小屏一行1个 (24/1=24)
    case 'sm': return 12       // 小屏一行2个 (24/2=12)
    case 'md': return 8        // 中屏一行3个 (24/3=8)
    case 'lg': return 6        // 大屏一行4个 (24/4=6)
    case 'xl': return Math.floor(24/5)  // 超大屏一行5个 (24/5=4.8≈下舍4)
    case 'xxl': return 4       // 超超大屏一行6个 (24/6=4)
    default: return 24
  }
}

onMounted(() => {
  queryStore.setDefaults(defaults)
})
defineExpose({ reset })
</script>
<style scoped>
:deep(.el-form-item__label) {
  font-size: 14px !important;
}

:deep(.el-form-item) {
  margin-bottom: 0px !important;
  flex-direction: column !important;
  align-items: flex-start !important;
}

:deep(.el-form-item__label) {
  font-size: 14px !important;
  margin-bottom: 0px !important;
  padding-bottom: 0 !important;
  line-height: 1.5 !important;
  font-weight: 500;
  height: auto !important;
}

:deep(.el-form-item__content) {
  width: 100% !important;
  margin-left: 0 !important;
}

/* 搜索表单行样式 */
.search-form-row {
  align-items: flex-start;
}

/* 搜索表单项样式 */
.search-form-item {
  margin-bottom: 16px;
}

/* 搜索项包装器 */
.search-item-wrapper {
  width: 100%;
}

/* 范围选择器包装器 */
.range-wrapper {
  width: 100%;
}

/* 搜索按钮区域 */
.search-buttons {
  margin-bottom: 16px;
  display: flex;
  align-items: center;
}

/* 确保表单元素填满容器宽度 */
:deep(.el-input),
:deep(.el-select),
:deep(.el-date-picker),
:deep(.el-input-number),
:deep(.el-tree-select) {
  width: 100%;
}

/* 响应式调整 */
@media (max-width: 768px) {
  .search-form-item {
    margin-bottom: 12px;
  }
  
  .search-buttons {
    margin-top: 8px;
  }
}
</style>
