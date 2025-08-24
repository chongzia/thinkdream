<template>
  <div style="width: 100%; overflow-x: auto;">
    <catch-table
      :columns="columns"
      :api="api"
      :search-form="search"
      :exports="true"
      exportUrl="snmp/snmp/export/users"
      importUrl="snmp/snmp/import/users"
      dialogWidth="800px"
      border
      size="small"
    >
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" :width="800" />
      </template>
    </catch-table>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import Create from './form/create.vue'
const api = "snmp/snmp/users"
// table columns
const columns = [
	{ prop: 'id', label: '编号', width: 80, align: 'center', fixed: 'left'},
	{ prop: 'name', label: '姓名', width: 150, align: 'center', ellipsis: true},
	{ prop: 'phone', label: '电话', width: 120, align: 'center'},
	{ prop: 'department_name', label: '部门', width: 280, align: 'left', ellipsis: true},
	{ prop: 'position_name', label: '岗位', width: 150, align: 'left', ellipsis: true},
	{ prop: 'device_name', label: '设备名称', width: 120, align: 'center', ellipsis: true},
	{ prop: 'device_ip', label: '设备ip', width: 120, align: 'center'},
	{ prop: 'device_mac', label: '设备mac', width: 140, align: 'center'},
	{ prop: 'device_authorize_name', label: '设备授权', width: 100, align: 'center'},
	{ prop: 'device_deal_status_name', label: '设备受理状态', width: 120, align: 'center'},
	{ prop: 'created_at', label: '创建时间', width: 160, align: 'center'},
	{ prop: 'updated_at', label: '更新时间', width: 160, align: 'center'},
	{ type: 'operate', label: '操作', width: 200, align: 'center', fixed: 'right'},
]
// table search
const search = [
	{ type: 'input', name: 'name', label: '姓名'},
	{ type: 'input', name: 'phone', label: '电话'},
	{ type: 'select', name: 'positions_id', label: '岗位', api: 'jobs'},
	{ type: 'tree', name: 'department_id', label: '部门', api: 'departments', props: { label: 'department_name', value: 'id' }},
	{ type: 'input', name: 'device_name', label: '设备名称'},
	{ type: 'input', name: 'device_ip', label: '设备ip'},
	{ type: 'input', name: 'device_mac', label: '设备mac'},
	{ type: 'select', name: 'device_authorize', label: '设备授权', api: 'DeviceAuthorize'},
	{ type: 'select', name: 'device_deal_status', label: '设备受理状态', api: 'DeviceDealStatus'},
]
</script>
