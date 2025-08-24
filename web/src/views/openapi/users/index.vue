<template>
  <div>
    <catch-table :columns="columns" :api="api" :search-form="search" ref="table">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>

      <template #operate="scope">
        <el-button size="small" text type="success" @click="openCharge(scope.row.id)"><Icon name="currency-yen" className="w-3 h-3" /> 充值</el-button>
        <el-button size="small" text @click="regenerate(scope.row.id)"> <Icon name="arrow-path" className="w-3 h-3" /> 重置密钥 </el-button>
      </template>
    </catch-table>
    <Dialog v-model="chargeVisible" title="充值额度">
      <div class="flex items-center justify-center py-10 gap-x-10">
        <div>充值额度:</div>
        <el-input-number :min="1" v-model="charge" :max="9999999" />
      </div>

      <div class="flex justify-center">
        <el-button type="primary" @click="chargeBalance()">确定</el-button>
      </div>
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import Create from './form/create.vue'
import http from '@/support/http'
import Message from '@/support/message'
import { ref } from 'vue'
const api = 'openapi/users'
const table = ref()
// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 100
  },
  {
    prop: 'username',
    label: '用户名',
    width: 150
  },
  {
    prop: 'mobile',
    label: '手机号',
    width: 150
  },
  {
    prop: 'app_key',
    label: 'AppKey'
  },
  {
    prop: 'app_secret',
    label: 'AppSecret',
    mask: true
  },
  {
    prop: 'qps',
    label: 'qps/分钟',
    width: 150
  },
  {
    prop: 'balance',
    label: '余额',
    width: 150
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    type: 'operate',
    label: '操作'
  }
]

// table search
const search = [
  {
    type: 'input',
    name: 'username',
    label: '用户名'
  },
  {
    type: 'input',
    name: 'mobile',
    label: '手机号'
  }
]

// 重新生成密钥
const regenerate = (id: any) => {
  http.put(`openapi/user/${id}/regenerate`).then(r => {
    Message.success('已重新生成')
  })
}

const chargeVisible = ref(false)
const charge = ref<number>(1)
const userId = ref(0)
const openCharge = (id: number) => {
  userId.value = id
  chargeVisible.value = true
}
const chargeBalance = () => {
  http.post('openapi/user/charge', { user_id: userId.value, balance: charge.value }).then(r => {
    charge.value = 1
    Message.success('充值成功')
    chargeVisible.value = false
    table.value.reset()
  })
}
</script>
