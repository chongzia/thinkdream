<template>
  <el-form :model="formData" label-width="120px" ref="form" v-loading="loading" class="w-9/12 pr-4 m-auto">
    <el-alert type="warning" title="当前优惠券已有用户领取，编辑信息已变更" v-if="usersCount" class="mb-10" />
    <el-form-item label="优惠券名称" prop="title" :rules="[{ required: true, message: '请填写优惠券名称' }]" class="mt-2">
      <el-input v-model="formData.title" name="title" clearable />
    </el-form-item>
    <div v-if="!usersCount">
      <el-form-item label="优惠卷类型" prop="type" :rules="[{ required: true, message: '请选择优惠卷类型' }]">
        <el-radio-group v-model="formData.type">
          <el-radio
            v-for="item in [
              { value: 1, label: '满减券' },
              { value: 2, label: '折扣券' }
            ]"
            :key="item.value"
            :value="item.value"
            name="type"
            >{{ item.label }}</el-radio
          >
        </el-radio-group>
      </el-form-item>
      <el-form-item label="减免金额" prop="reduce_price" :rules="[{ required: true, message: '请先填写减免金额' }]" v-if="formData.type === 1">
        <el-input-number v-model="formData.reduce_price" name="reduce_price" :min="1" controls-position="right" :precision="2" /><span class="ml-2">元</span>
      </el-form-item>
      <el-form-item label="折扣率" prop="discount" :rules="[{ required: true, message: '请先填写折扣率' }]" v-if="formData.type === 2">
        <div>
          <el-input-number v-model="formData.discount" name="discount" :step="0.1" :max="9.9" :min="1" controls-position="right" :precision="1" /><span class="ml-2">%</span>
          <Prompt text="折扣率范围 0-9.9，8代表打8折，0代表不折扣" />
        </div>
      </el-form-item>
      <el-form-item label="最低消费金额" prop="min_price" :rules="[{ required: true, message: '请先填写最低消费金额' }]" class="mt-7">
        <el-input-number v-model="formData.min_price" name="min_price" :min="1" controls-position="right" :precision="2" /><span class="ml-2">元</span>
      </el-form-item>
      <el-form-item label="到期类型" prop="expire_type" :rules="[{ required: true }]">
        <el-radio-group v-model="formData.expire_type">
          <el-radio
            v-for="item in [
              { value: 1, label: '领取后生效' },
              { value: 2, label: '固定时间' }
            ]"
            :key="item.value"
            :value="item.value"
            name="expire_type"
            >{{ item.label }}</el-radio
          >
        </el-radio-group>
      </el-form-item>
      <!-- 有效期 -->
      <el-form-item label="有效期" prop="validaty" :rules="[{ required: true }]" v-if="formData.expire_type === 1">
        <el-input-number v-model="formData.validaty" name="validaty" :min="1" controls-position="right" /> <span class="ml-2">天</span>
      </el-form-item>
      <el-form-item v-if="formData.expire_type === 2">
        <div class="flex">
          <el-date-picker v-model="formData.start_at" type="date" placeholder="开始时间" />
          <span class="mx-2 text-gray-400">~</span>
          <el-date-picker v-model="formData.end_at" type="date" placeholder="结束时间" />
        </div>
      </el-form-item>
      <el-form-item label="适用范围" prop="scope" :rules="[{ required: true }]">
        <el-radio-group v-model="formData.scope">
          <el-radio
            v-for="item in [
              { value: 1, label: '全场通用' },
              { value: 2, label: '指定商品' }
            ]"
            :key="item.value"
            :value="item.value"
            name="scope"
            >{{ item.label }}</el-radio
          >
        </el-radio-group>
      </el-form-item>
      <el-form-item prop="scope_data" :rules="[{ required: true, message: '请先选择商品' }]">
        <SelectProducts v-if="formData.scope === 2" v-model="formData.scope_data" />
      </el-form-item>
      <!--
      <Select-Table api="/shop/products" v-model="formData.scope_data" class="w-64" placeholder="请选择指定商品" :searchParams="searchParams">
        <template #header>
          <el-input placeholder="请输入标题" v-model="searchParams.title" />
        </template>
        <template #other="scope">
          <image :src="scope.row.images[0]" />
        </template>
      </Select-Table>-->
    </div>
    <el-form-item label="总数量" prop="total_num" :rules="[{ required: true }]">
      <div>
        <el-input-number v-model="formData.total_num" name="total_num" :min="1" controls-position="right" /><span class="ml-2">张</span>
        <Prompt text="发放优惠券的总数量" />
      </div>
    </el-form-item>

    <el-form-item label="状态" prop="status" :rules="[{ required: true }]">
      <el-radio-group v-model="formData.status">
        <el-radio
          v-for="item in [
            { value: 1, label: '显示' },
            { value: 2, label: '隐藏' }
          ]"
          :key="item.value"
          :value="item.value"
          name="status"
          >{{ item.label }}</el-radio
        >
      </el-radio-group>
    </el-form-item>
    <el-form-item label="优惠券描述" prop="sort" :rules="[{ required: true, message: '请输入优惠券说明' }]">
      <el-input v-model="formData.describe" :autosize="{ minRows: 2, maxRows: 4 }" type="textarea" placeholder="请输入优惠券描述" />
    </el-form-item>
    <el-form-item label="排序" prop="sort" :rules="[{ required: true }]">
      <div>
        <el-input-number v-model="formData.sort" name="sort" :min="1" />
        <Prompt text="数字越大越靠前，倒叙排序" />
      </div>
    </el-form-item>
    <div class="flex justify-end">
      <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
    </div>
  </el-form>
</template>

<script lang="ts" setup>
// @ts-nocheck
import { useCreate } from '@/composables/curd/useCreate'
import { useShow } from '@/composables/curd/useShow'
import SelectProducts from '@/views/shop/components/selectProducts/index.vue'
import { inject, onMounted } from 'vue'

const props = defineProps({
  primary: [String, Number],
  api: String,
  usersCount: {
    type: Number,
    default: 0
  }
})

const { formData, form, loading, submitForm, close } = useCreate(props.api as string, props.primary)
formData.value.total_num = 1
formData.value.status = 1
formData.value.type = 1
formData.value.expire_type = 1
formData.value.sort = 1
formData.value.scope = 1
formData.value.validaty = 7

if (props.primary) {
  useShow(props.api as string, props.primary, formData)
}

const closeDialog = inject('closeDialog') as Function
onMounted(() => {
  close(() => closeDialog())
})
</script>
