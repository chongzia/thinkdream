<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
    <el-form-item
      label="模版名称"
      prop="name"
      :rules="[
        {
          required: true,
          message: '模版名称必须填写'
        }
      ]"
    >
      <el-input v-model="formData.name" name="name" clearable />
    </el-form-item>

    <el-form-item label="模版规格">
      <el-button @click="addSpec" type="primary">新增规格</el-button>
      <el-table :data="formData.specs" border class="mt-3">
        <el-table-column label="规格名称" width="200" prop="name">
          <template #default="scope">
            <el-input v-model="scope.row.name" name="name" clearable placeholder="请输入规格名称" />
          </template>
        </el-table-column>
        <el-table-column label="规格值" prop="specValues">
          <template #default="scope">
            <div class="grid grid-cols-4 gap-x-1 gap-y-2">
              <div v-for="specValue in scope.row.values" :key="specValue" class="w-48 flex">
                <el-input name="name" clearable v-model="specValue.value" placeholder="请输入规格值" />
                <div class="w-14 h-6 flex pt-1 pl-1">
                  <Icon name="trash" className="w-5 h-5 ml-1 text-red-600 cursor-pointer" @click="destroySpecValue(scope.row.key, specValue.key)" />
                </div>
              </div>
              <div class="w-12 flex items-center justify-center cursor-pointer" @click="addSpecValue(scope.row.key)">
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
    <div></div>
    <div class="flex justify-end">
      <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
    </div>
  </el-form>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { useCreate } from '@/composables/curd/useCreate'
import { useShow } from '@/composables/curd/useShow'

import { inject, onMounted } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
} else {
  formData.value.specs = []
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})

// 新增规格
const addSpec = () => {
  formData.value.specs.push({
    name: '',
    key: formData.value.specs.length,
    values: [{ value: '', key: 0 }]
  })
}

// 添加规格值
const addSpecValue = key => {
  formData.value.specs[key].values.push({ value: '', key: formData.value.specs[key].values.length })
}

// 删除规格值
const destroySpecValue = (key, index) => {
  formData.value.specs[key].values = formData.value.specs[key].values.filter(item => {
    return item.key !== index
  })
}

// 删除规格
const destroySpec = key => {
  formData.value.specs = formData.value.specs.filter(item => {
    return item.key !== key
  })
}
</script>
