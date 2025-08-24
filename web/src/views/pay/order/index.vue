<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false" ref="table" :search-form="search">
      <template #operate="scope">
        <el-button size="small" type="success" v-if="scope.row.refund_status === 0" @click="showRefund(scope.row.id, scope.row.order_no, scope.row.amount)">退款</el-button>
      </template>
    </catch-table>

    <Dialog v-model="showRefundVisible" title="订单退款" destroy-on-close>
      <Refund :order_id="orderId" :order_no="refundOrderNo" :order_amount="orderAmount" @closeRefund="closeRefund" />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import Refund from './refund.vue'
const showRefundVisible = ref(false)
const orderId = ref(0)
const refundOrderNo = ref('')
const orderAmount = ref(0)
const api = 'pay/order'
const table = ref()
const showRefund = (id: number, orderNo: string, amount: number) => {
  showRefundVisible.value = true
  orderId.value = id
  refundOrderNo.value = orderNo
  orderAmount.value = amount
  table.value.reset()
}
const closeRefund = () => {
  showRefundVisible.value = false
  orderId.value = 0
  refundOrderNo.value = ''
  orderAmount.value = 0
  table.value.reset()
}

// table columns
const columns = [
  {
    prop: 'id',
    label: 'ID',
    width: 80
  },
  {
    prop: 'subject_id',
    label: '商品ID'
  },
  {
    prop: 'user_id',
    label: '用户ID'
  },
  {
    prop: 'order_no',
    label: '本地订单号',
    width: 320
  },
  {
    prop: 'out_trade_no',
    label: '外部订单号'
  },
  {
    prop: 'amount',
    label: '金额/元'
  },
  {
    prop: 'platform',
    label: '支付平台',
    tags: ['primary', 'danger', 'warning', 'success'],
    filter: (value: number) => {
      return ['支付宝', '微信', '抖音', '快手'][value - 1]
    }
  },
  {
    prop: 'action',
    label: '支付操作'
  },
  {
    prop: 'pay_status',
    label: '支付状态',
    tags: ['primary', 'success', 'danger', 'warning'],
    filter: (value: number) => {
      return ['待支付', '已支付', '支付失败', '超时未支付'][value - 1]
    }
  },
  {
    prop: 'refund_status',
    label: '退款状态',
    filter: (value: number) => {
      return ['', '待退款', '退款成功', '退款失败', '拒绝'][value]
    }
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    type: 'operate',
    update: false,
    destroy: false,
    label: '操作'
  }
]
// table search
const search = [
  {
    name: 'order_no',
    label: '订单号',
    type: 'input'
  },
  {
    name: 'out_trade_no',
    label: '平台单号',
    type: 'input'
  },
  {
    name: 'status',
    label: '订单状态',
    type: 'select',
    options: [
      { label: '待支付', value: 0 },
      { label: '已支付', value: 1 },
      { label: '支付失败', value: 2 },
      { label: '超时未支付', value: 3 }
    ]
  },
  {
    name: 'refund_status',
    label: '退款状态',
    type: 'select',
    options: [
      { label: '退款中', value: 1 },
      { label: '退款成功', value: 2 },
      { label: '退款失败', value: 3 },
      { label: '拒绝', value: 4 }
    ]
  }
]
</script>
