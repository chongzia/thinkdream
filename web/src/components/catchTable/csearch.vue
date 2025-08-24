<template>
  <div class="grid w-full grid-cols-1 gap-2 pl-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 place-content-between">
    <template v-for="(item, k) in fields" :key="k">
      <div v-show="item.show && (k < 4 || expand)" :class="'align-items-center ' + (item.type === 'range' ? ' col-span-2' : '')">
        <el-form-item :label="item.label" v-if="item.type === 'input'">
          <el-input :placeholder="item.placeholder" v-model="queryStore.getTableQuery[item.name]" clearable />
        </el-form-item>
        <el-form-item :label="item.label" v-if="item.type === 'select'">
          <Select :api="item.api" :options="item.options" v-model="queryStore.getTableQuery[item.name]" :query="item.query" :placeholder="item.placeholder" />
        </el-form-item>
        <el-form-item :label="item.label" v-if="item.type === 'input-number'">
          <el-input-number v-model="queryStore.getTableQuery[item.name]" :placeholder="item.placeholder" clearable />
        </el-form-item>
        <el-form-item :label="item.label" v-if="item.type === 'date'">
          <el-date-picker type="date" v-model="queryStore.getTableQuery[item.name]" :placeholder="item.placeholder" clearable value-format="YYYY-MM-DD" />
        </el-form-item>
        <el-form-item :label="item.label" v-if="item.type === 'datetime'">
          <el-date-picker type="datetime" v-model="queryStore.getTableQuery[item.name]" :placeholder="item.placeholder" clearable value-format="YYYY-MM-DD HH:mm:ss" />
        </el-form-item>
        <el-form-item :label="item.label" v-if="item.type === 'tree'">
          <el-tree-select v-model="queryStore.getTableQuery[item.name]" value-key="id" :placeholder="item.placeholder" clearable :data="item.options" check-strictly :props="item.props" />
        </el-form-item>
        <div class="flex flex-wrap w-full" v-show="item.type === 'range'">
          <el-form-item :label="item.label">
            <div class="flex gap-x-2">
              <div v-for="(sitem, key) in item.children" :key="key">
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
                <el-input-number v-model="queryStore.getTableQuery[sitem.name]" :placeholder="sitem.placeholder" v-if="sitem.type === 'input-number'" clearable />
                <el-date-picker type="date" v-model="queryStore.getTableQuery[sitem.name]" :placeholder="sitem.placeholder" v-if="sitem.type === 'date'" clearable value-format="YYYY-MM-DD" />
                <el-date-picker
                  type="datetime"
                  v-model="queryStore.getTableQuery[sitem.name]"
                  :placeholder="sitem.placeholder"
                  v-if="sitem.type === 'datetime'"
                  clearable
                  value-format="YYYY-MM-DD HH:mm:ss"
                />
              </div>
            </div>
          </el-form-item>
        </div>
      </div>
    </template>
    <div class="flex justify-end col-end-0 sm:col-end-5 lg:col-end-8">
      <el-button type="primary" @click="search" :disabled="loading"> {{ t('system.search') }} </el-button>
      <el-button @click="reset" :disabled="loading"> {{ t('system.reset') }} </el-button>
      <el-button @click="expandSearch()" v-if="fields.length > 3" text circle>
        <Icon :name="expand ? 'chevron-up' : 'chevron-down'" className="w-4 h-4" />
      </el-button>
    </div>
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
}
</style>
