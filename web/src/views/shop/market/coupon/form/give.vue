<template>
  <div class="bg-white dark:bg-regal-dark" v-loading="loading">
    <el-form label-width="120px" ref="form" class="w-full px-2 py-10 m-auto lg:2/3 xl:w-1/2" :model="formData">
      <el-alert title="选择指定的优惠券仅一张发放给指定的用户, 发放成功后无法撤销，请谨慎操作" type="warning" show-icon class="px-2" />

      <el-form-item label="优惠券名称" :rules="[{ required: true }]" class="mt-5">
        <div class="text-lg text-gray-700">{{ coupon.title }} <Prompt :text="'剩余 ' + (coupon.total_num - coupon.receive_num) + ' 张'" /></div>
      </el-form-item>
      <el-form-item label="发放类型" :rules="[{ required: true }]">
        <el-radio-group v-model="formData.type">
          <el-radio
            v-for="item in [
              { value: 1, label: '指定会员' }
              // { value: 2, label: '隐藏' }
            ]"
            :key="item.value"
            :value="item.value"
            name="type"
            >{{ item.label }}</el-radio
          >
        </el-radio-group>
      </el-form-item>
      <el-form-item label="指定会员" prop="users" :rules="[{ required: true, message: '请选择发放会员' }]">
        <Select-Remote api="member/members" label="username" value="id" v-model="formData.users" title="username" />
      </el-form-item>
      <div class="flex justify-center gap-x-2">
        <el-button type="primary" @click="submitForm(form)">{{ $t('system.confirm') }}</el-button>
        <router-link to="/shop/market/coupon/index">
          <el-button plain>返回</el-button>
        </router-link>
      </div>
    </el-form>
  </div>
</template>
<script lang="ts" setup>
// @ts-nocheck
import router from '@/router'
import http from '@/support/http'
import { onMounted, ref } from 'vue'
import { useCreate } from '@/composables/curd/useCreate'

const id = router.currentRoute.value.params.id
console.log(id)
const coupon = ref({})
const getCoupon = () => {
  http.get(`shop/coupon/${id}`).then(r => {
    coupon.value = r.data.data
  })
}

const { formData, form, loading, submitForm } = useCreate('shop/coupon/give/' + id, null)
formData.value.type = 1
onMounted(() => {
  getCoupon()
})
</script>
