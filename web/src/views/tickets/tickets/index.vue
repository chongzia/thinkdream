<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false" :show-header="true" :search-form="searchForm">
      <!-- 自定义操作列 -->
      <template #operate="scope">
        <div class="action-buttons">
          <el-button size="small" type="primary" text @click="handleViewTicketDetail(scope.row)" class="action-btn">
            <el-icon size="14">
              <View />
            </el-icon>
            详情
          </el-button>

          <el-button size="small" type="success" text @click="handleViewFormData(scope.row)"
            v-if="scope.row.ticket_data" class="action-btn">
            <el-icon size="14">
              <Document />
            </el-icon>
            流程
          </el-button>


          <el-divider direction="vertical" />

          <el-button size="small" type="danger" text @click="handleDelete(scope.row)" class="action-btn">
            <el-icon size="14">
              <Delete />
            </el-icon>
            删除
          </el-button>
        </div>
      </template>
    </catch-table>

    <!-- 工单详情弹窗 -->
    <el-dialog v-model="ticketDetailDialogVisible" title="详情" width="90%"
      :before-close="handleTicketDetailDialogClose">
      <TicketDetailViewer v-if="ticketDetailDialogVisible && currentTicketRow" :ticket="currentTicketRow" />
    </el-dialog>

    <!-- 表单数据查看弹窗 -->
    <el-dialog v-model="formDataDialogVisible" title="流程" width="80%" :before-close="handleFormDataDialogClose">
      <FormDataViewer v-if="formDataDialogVisible && currentFormData" :form-data="currentFormData"
        :template-id="currentTemplateId" />
    </el-dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, computed } from 'vue'
import { ElMessageBox, ElMessage } from 'element-plus'
import { View, Document, Files, Delete } from '@element-plus/icons-vue'
import http from '@/support/http'
import TicketTemplate from './components/TemplateViewer.vue'
import FormDataViewer from './components/FormDataViewer.vue'
import TicketDetailViewer from './components/TicketDetailViewer.vue'

const api = "tickets/tickets"

// 用户映射缓存
const userMap = ref<Map<number, string>>(new Map())
const loading = ref(false)

// 弹窗状态管理
const templateDialogVisible = ref(false)
const formDataDialogVisible = ref(false)
const ticketDetailDialogVisible = ref(false)

// 当前数据引用
const currentTemplateId = ref<number | undefined>(undefined)
const currentFormData = ref<string | undefined>(undefined)
const currentTicketRow = ref<any>(null)

// 字典数据缓存
const statusOptions = ref<Map<number, string>>(new Map())
const priorityOptions = ref<Map<number, string>>(new Map())
const statusOptionsLoaded = ref(false)
const priorityOptionsLoaded = ref(false)

// 获取用户列表
const fetchUsers = async () => {
  if (loading.value) return
  loading.value = true
  try {
    const userIds = Array.from({ length: 100 }, (_, i) => i + 1)
    const response = await http.get('/users/batch', { user_ids: userIds })
    if (response.data?.data) {
      userMap.value.clear()
      response.data.data.forEach((user: any) => {
        if (user.id && user.nickname) {
          userMap.value.set(user.id, user.nickname)
        }
      })
    }
  } catch (error) {
    console.error('获取用户列表失败:', error)
  } finally {
    loading.value = false
  }
}



// 获取用户名称
const getUserName = (userId: number | string): string => {
  if (!userId) return '-'
  
  const getSingleUserName = (id: string | number) => {
    const numId = typeof id === 'string' ? parseInt(id) : id
    return userMap.value.get(numId) || numId.toString()
  }

  if (typeof userId === 'string' && userId.includes(',')) {
    return userId.split(',').map(id => id.trim()).filter(id => id).map(getSingleUserName).join(', ')
  }
  
  return getSingleUserName(userId)
}

// 获取字典数据
const fetchDictionaries = async () => {
  try {
    const [statusResponse, priorityResponse] = await Promise.all([
      http.get('options/ticketStatus'),
      http.get('options/ticketPriority')
    ])
    
    if (statusResponse.data?.data) {
      statusResponse.data.data.forEach((item: any) => statusOptions.value.set(item.value, item.label))
      statusOptionsLoaded.value = true
    }
    
    if (priorityResponse.data?.data) {
      priorityResponse.data.data.forEach((item: any) => priorityOptions.value.set(item.value, item.label))
      priorityOptionsLoaded.value = true
    }
  } catch (error) {
    console.error('获取字典数据失败:', error)
  }
}

// 获取字典名称
const getDictName = (map: Map<number, string>, value: number): string => {
  return map.get(value) || value.toString()
}

// 处理弹窗显示
const handleViewTicketDetail = (row: any) => {
  currentTicketRow.value = row
  ticketDetailDialogVisible.value = true
}

const handleViewFormData = (row: any) => {
  currentFormData.value = row.ticket_data
  currentTemplateId.value = row.ticket_template
  formDataDialogVisible.value = true
}

const handleViewTemplate = (row: any) => {
  currentTemplateId.value = row.ticket_template
  templateDialogVisible.value = true
}

// 处理删除
const handleDelete = async (row: any) => {
  try {
    await ElMessageBox.confirm(
      `确定要删除工单"${row.ticket_name || row.ticket_no}"吗？此操作不可恢复。`,
      '删除确认',
      { confirmButtonText: '确定删除', cancelButtonText: '取消', type: 'warning', confirmButtonClass: 'el-button--danger' }
    )
    
    const response = await http.delete(`${api}/${row.id}`)
    if (response.data?.code === 200) {
      ElMessage.success('工单删除成功')
      window.location.reload()
    } else {
      ElMessage.error('删除失败：' + (response.data?.message || '未知错误'))
    }
  } catch (error) {
    if (error !== 'cancel') {
      console.error('删除工单失败:', error)
      ElMessage.error('删除失败，请稍后重试')
    }
  }
}

// 弹窗关闭处理
const handleTemplateDialogClose = () => {
  templateDialogVisible.value = false
  currentTemplateId.value = undefined
}

const handleFormDataDialogClose = () => {
  formDataDialogVisible.value = false
  currentFormData.value = undefined
  currentTemplateId.value = undefined
}

const handleTicketDetailDialogClose = () => {
  ticketDetailDialogVisible.value = false
  currentTicketRow.value = null
}

// 组件挂载时获取数据
onMounted(() => {
  fetchUsers()
  fetchDictionaries()
})

// 字段配置定义
const fieldConfigs = {
  ticket_no: { label: '工单编号', width: 140 },
  ticket_name: { label: '工单标题', width: 200, showOverflowTooltip: true },
  ticket_status: { label: '状态', width: 100, align: 'center', tags: ['primary', 'warning', 'danger', 'info', 'success'] },
  ticket_priority: { label: '优先级', width: 90, align: 'center', tags: ['success', 'primary', 'warning', 'danger'] },
  ticket_promoter: { label: '发起人', width: 100 },
  ticket_process_position: { label: '受理人', width: 100 },
  ticket_node_process: { label: '处理人', width: 120 },
  ticket_accept_at: { label: '受理时间', width: 160 },
  ticket_accept_overdue: { label: '受理超期', width: 90, align: 'center', tags: ['success', 'danger'] },
  ticket_process_at: { label: '处理时间', width: 160 },
  ticket_process_overdue: { label: '处理超期', width: 90, align: 'center', tags: ['success', 'danger'] },
  created_at: { label: '创建时间', width: 160 },
  closed_at: { label: '关闭时间', width: 160 }
}

// 超期状态选项
const overdueOptions = [
  { label: '正常', value: 0 },
  { label: '超期', value: 1 }
]

// 搜索表单配置
const searchForm = [
  { type: 'input', name: 'ticket_no', label: fieldConfigs.ticket_no.label, placeholder: '请输入工单编号' },
  { type: 'input', name: 'ticket_name', label: fieldConfigs.ticket_name.label, placeholder: '请输入工单标题' },
  { 
    type: 'select', 
    name: 'ticket_status', 
    label: fieldConfigs.ticket_status.label, 
    placeholder: '请选择工单状态',
    options: Array.from(statusOptions.value.entries()).map(([value, label]) => ({ value, label }))
  },
  { 
    type: 'select', 
    name: 'ticket_priority', 
    label: fieldConfigs.ticket_priority.label, 
    placeholder: '请选择优先级',
    options: Array.from(priorityOptions.value.entries()).map(([value, label]) => ({ value, label }))
  },
  { 
    type: 'select', 
    name: 'ticket_promoter', 
    label: fieldConfigs.ticket_promoter.label, 
    placeholder: '请选择发起人',
    options: Array.from(userMap.value.entries()).map(([value, label]) => ({ value, label }))
  },
  { 
    type: 'select', 
    name: 'ticket_process_position', 
    label: fieldConfigs.ticket_process_position.label, 
    placeholder: '请选择受理人',
    options: Array.from(userMap.value.entries()).map(([value, label]) => ({ value, label }))
  },
  { type: 'select', name: 'ticket_accept_overdue', label: fieldConfigs.ticket_accept_overdue.label, placeholder: '请选择受理超期状态', options: overdueOptions },
  { type: 'select', name: 'ticket_process_overdue', label: fieldConfigs.ticket_process_overdue.label, placeholder: '请选择处理超期状态', options: overdueOptions },
  { type: 'date', name: 'created_at', label: fieldConfigs.created_at.label, placeholder: '请选择创建时间' },
  { type: 'date', name: 'ticket_accept_at', label: fieldConfigs.ticket_accept_at.label, placeholder: '请选择受理时间' },
  { type: 'date', name: 'closed_at', label: fieldConfigs.closed_at.label, placeholder: '请选择关闭时间' }
]

// 时间格式化函数
const formatTime = (timestamp: number) => timestamp ? new Date(timestamp * 1000).toLocaleString() : '-'

// 超期状态格式化函数
const formatOverdue = (value: number) => value === 1 ? '超期' : '正常'

// table columns - 使用公共配置
const columns = computed(() => [
  { prop: 'id', label: '编号', width: 80 },
  { prop: 'ticket_no', ...fieldConfigs.ticket_no },
  { prop: 'ticket_name', ...fieldConfigs.ticket_name },
  { 
    prop: 'ticket_status', 
    ...fieldConfigs.ticket_status,
    filter: (value: number) => getDictName(statusOptions.value, value)
  },
  { 
    prop: 'ticket_priority', 
    ...fieldConfigs.ticket_priority,
    filter: (value: number) => getDictName(priorityOptions.value, value)
  },
  { 
    prop: 'ticket_promoter', 
    ...fieldConfigs.ticket_promoter,
    filter: (userId: number) => userId ? getUserName(userId) : '-'
  },
  { 
    prop: 'ticket_process_position', 
    ...fieldConfigs.ticket_process_position,
    filter: (userId: number) => userId ? getUserName(userId) : '-'
  },
  { 
    prop: 'ticket_node_process', 
    ...fieldConfigs.ticket_node_process,
    filter: (userIds: string) => userIds ? getUserName(userIds) : '-'
  },
  { 
    prop: 'ticket_accept_at', 
    ...fieldConfigs.ticket_accept_at,
    filter: formatTime
  },
  { 
    prop: 'ticket_accept_overdue', 
    ...fieldConfigs.ticket_accept_overdue,
    filter: formatOverdue
  },
  { 
    prop: 'ticket_process_at', 
    ...fieldConfigs.ticket_process_at,
    filter: formatTime
  },
  { 
    prop: 'ticket_process_overdue', 
    ...fieldConfigs.ticket_process_overdue,
    filter: formatOverdue
  },
  { prop: 'created_at', ...fieldConfigs.created_at },
  { 
    prop: 'closed_at', 
    ...fieldConfigs.closed_at,
    filter: formatTime
  },
  {
    type: 'operate',
    label: '操作',
    width: 280,
    fixed: 'right',
    update: false,
    destroy: false,
  }
])
</script>

<style scoped>
.action-buttons {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
}

.action-btn {
  padding: 4px 8px;
  border-radius: 4px;
  transition: all 0.2s ease;
}

.action-btn:hover {
  background-color: var(--el-fill-color-light);
}

:deep(.el-divider--vertical) {
  height: 16px;
  margin: 0 4px;
}

:deep(.el-table) {
  border-radius: 8px;
}

:deep(.el-table th) {
  background-color: var(--el-fill-color-light);
  font-weight: 600;
}

:deep(.el-table td) {
  padding: 8px 0;
}

:deep(.el-button.is-disabled) {
  opacity: 0.4;
}
</style>