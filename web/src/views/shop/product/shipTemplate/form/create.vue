<template>
  <div>
    <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="pr-4">
      <el-form-item
        label="模版名称"
        prop="title"
        :rules="[
          {
            required: true,
            message: '模版名称必须填写'
          }
        ]"
      >
        <el-input v-model="formData.title" name="title" clearable class="w-1/2" />
      </el-form-item>
      <el-form-item label="计费方式" prop="bill_type">
        <el-radio-group v-model="formData.bill_type" class="ml-4">
          <el-radio
            :label="item.value"
            size="large"
            v-for="item in [
              { label: '按件数', value: 1 },
              { label: '按重量', value: 2 },
              { label: '按体积', value: 3 }
            ]"
            :key="item.value"
            >{{ item.label }}</el-radio
          >
        </el-radio-group>
      </el-form-item>
      <el-form-item label="配送区域及运费" prop="delivery_areas">
        <el-table :data="formData.delivery_areas" class="w-full mt-3" border max-height="600">
          <el-table-column prop="price" label="可配送区域">
            <template #default="scope">
              <div v-if="scope.row.areas === 0" @click="openAreaVisible(scope.row.key)" class="cursor-pointer">全国</div>
              <div v-else-if="scope.row.areas.length === 0"><el-button size="small" @click="openAreaVisible(scope.row.key, scope.row.areas)" class="cursor-pointer">选择区域</el-button></div>
              <div v-else class="grid grid-cols-2 gap-1 cursor-pointer" @click="openAreaVisible(scope.row.key, scope.row.areas)">
                <div v-for="(item, index) in scope.row.areas" :key="index">
                  {{ item.name + (item.total === item.children.length ? '(全省)' : '(' + item.children[0].name + ')...') }}
                </div>
              </div>
            </template>
          </el-table-column>
          <el-table-column prop="list_price" :label="'首件' + (formData.bill_type === 2 ? '重量(KG)' : formData.bill_type === 3 ? '体积(m3)' : '')">
            <template #default="scope">
              <el-input-number v-model="scope.row.first_item" :min="0" controls-position="right" :step="1" size="small" />
            </template>
          </el-table-column>
          <el-table-column prop="cost_price" label="运费(元)">
            <template #default="scope">
              <el-input-number v-model="scope.row.ship_fee" :min="0" controls-position="right" :precision="2" :step="0.1" size="small" />
            </template>
          </el-table-column>
          <el-table-column prop="weight" :label="'续件' + (formData.bill_type === 2 ? '重量(KG)' : formData.bill_type === 3 ? '体积(m3)' : '')">
            <template #default="scope">
              <el-input-number v-model="scope.row.additional_part" :min="0" controls-position="right" :step="1" size="small" />
            </template>
          </el-table-column>
          <el-table-column prop="volume" label="续费(元)">
            <template #default="scope">
              <el-input-number v-model="scope.row.renewal" :min="0" controls-position="right" :precision="2" :step="0.1" size="small" />
            </template>
          </el-table-column>
          <el-table-column label="操作" width="60">
            <template #default="scope">
              <Icon name="trash" className="w-5 h-5 text-red-600" @click="destroyArea(scope.row.key)" />
            </template>
          </el-table-column>
        </el-table>
        <div>
          <el-button type="primary" @click="addArea" class="mt-2">添加配送区域</el-button>
        </div>
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="formData.sort" name="sort" :min="1" />
      </el-form-item>
      <div class="flex justify-end">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
      </div>
    </el-form>
    <Dialog v-model="areaVisible" title="配送区域" width="1200px" :lock-scroll="true" destroy-on-close>
      <Area @close-dialog="closeAreaVisible" v-model="selectedAreas" />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { useCreate } from '@/composables/curd/useCreate'
import { useShow } from '@/composables/curd/useShow'
import { inject, onMounted, ref } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String
})

const areaVisible = ref(false)
const selectedAreas = ref([])
const currentSelectKey = ref(0)
const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)
// 初始化
formData.value.sort = 1
formData.value.bill_type = 1
formData.value.delivery_areas = []
if (props.primary) {
  useShow(props.api as string, props.primary, formData)
} else {
  // 默认全国数据
  formData.value.delivery_areas.push({
    areas: 0,
    key: 0,
    first_item: 1,
    additional_part: 0,
    ship_fee: 0,
    renewal: 0
  })
}

// 新增送达区域
const addArea = () => {
  formData.value.delivery_areas.push({
    areas: [],
    key: formData.value.delivery_areas.length,
    first_item: 1,
    additional_part: 0,
    ship_fee: 0,
    renewal: 0
  })
}

// 删除区域
const destroyArea = (k: number) => {
  formData.value.delivery_areas = formData.value.delivery_areas.filter(a => {
    return a.key !== k
  })
}
// 关闭区域选择
const closeAreaVisible = () => {
  areaVisible.value = false
  formData.value.delivery_areas[currentSelectKey.value].areas = selectedAreas.value
}
// 打开区域选择
const openAreaVisible = (k: number, area: Array<any>) => {
  areaVisible.value = true
  currentSelectKey.value = k
  console.log(area)
  selectedAreas.value = area as []
}
const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
