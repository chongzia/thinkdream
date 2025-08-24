<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false" ref="table" :search-form="search">
      <template #operate="scope">
        <el-button size="small" v-if="scope.row.refund_status === 1" type="success" @click="showAgree(scope.row.id, scope.row.order_no, scope.row.refund_no, scope.row.amount)">同意</el-button>
      </template>
    </catch-table>

    <Dialog v-model="showAgreeVisible" title="处理退款订单" destroy-on-close>
      <Agree :refund_id="refundId" :order_no="orderNo" :refund_no="refundNo" :refund_amount="refundAmount" @closeAgree="closeAgree" />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import Agree from './agree.vue'
const api = 'pay/order/refund'
const showAgreeVisible = ref(false)
const refundId = ref(0)
const orderNo = ref('')
const refundNo = ref('')
const refundAmount = ref(0)
const table = ref()
const showAgree = (id: number, _orderNo: string, _refundNo: string, amount: number) => {
  showAgreeVisible.value = true
  refundId.value = id
  orderNo.value = _orderNo
  refundNo.value = _refundNo
  refundAmount.value = amount
  table.value.reset()
}
const closeAgree = () => {
  showAgreeVisible.value = false
  refundId.value = 0
  orderNo.value = ''
  refundNo.value = ''
  refundAmount.value = 0
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
    prop: 'order_no',
    label: '订单号',
    width: 300
  },
  {
    prop: 'refund_no',
    label: '退款单号',
    width: 320
  },
  {
    prop: 'amount',
    label: '退款金额/元'
  },
  {
    prop: 'reason',
    label: '退款原因'
  },
  {
    prop: 'refund_status',
    label: '退款状态',
    tags: ['primary', 'success', 'danger'],
    filter: (value: number) => {
      return ['退款中', '退款成功', '退款失败', '拒绝'][value - 1]
    }
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    prop: 'updated_at',
    label: '更新时间'
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
    name: 'refund_no',
    label: '退款单号',
    type: 'input'
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
