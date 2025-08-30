<template>
  <div>
    <catch-table 
      :columns="columns" 
      :api="api" 
      :operation="false" 
      :show-header="true" 
      :search-form="searchForm"
    >
      <!-- 操作列 -->
      <template #operate="scope">
        <div class="action-buttons">
          <el-button size="small" type="primary" text @click="handleViewTicketDetail(scope.row)" class="action-btn">
            <el-icon size="14"><View /></el-icon>
            详情
          </el-button>
          
          <el-button 
            size="small" 
            type="success" 
            text 
            @click="handleViewFormData(scope.row)"
            v-if="scope.row.ticket_data" 
            class="action-btn"
          >
            <el-icon size="14"><Document /></el-icon>
            流程
          </el-button>

          <el-divider direction="vertical" />

          <el-button size="small" type="danger" text @click="handleDelete(scope.row)" class="action-btn">
            <el-icon size="14"><Delete /></el-icon>
            删除
          </el-button>
        </div>
      </template>

      <!-- 当前处理人列 -->
      <template #current_processor="scope">
        <el-tag 
          :type="getProcessorTagType(scope.row)"
          size="small"
        >
          {{ TicketUtils.getCurrentProcessor(scope.row, dataCache.users) }}
        </el-tag>
      </template>

      <!-- 受理状态列 -->
      <template #accept_overdue_status="scope">
        <el-tag :type="getOverdueTagType(TicketUtils.calculateAcceptOverdueStatus(scope.row))">
          {{ TicketUtils.calculateAcceptOverdueStatus(scope.row) }}
        </el-tag>
      </template>

      <!-- 处理状态列 -->
      <template #process_overdue_status="scope">
        <el-tag :type="getOverdueTagType(TicketUtils.calculateProcessOverdueStatus(scope.row))">
          {{ TicketUtils.calculateProcessOverdueStatus(scope.row) }}
        </el-tag>
      </template>

      <!-- 状态列 -->
      <template #ticket_status="scope">
        <el-tag 
          :type="getStatusTagType(scope.row.ticket_status)"
          size="small"
          v-if="scope.row.ticket_status"
        >
          {{ TicketUtils.getDictName(dataCache.statusOptions, scope.row.ticket_status) }}
        </el-tag>
        <span v-else class="text-gray-400">-</span>
      </template>

      <!-- 优先级列 -->
      <template #ticket_priority="scope">
        <el-tag 
          :type="getPriorityTagType(scope.row.ticket_priority)"
          size="small"
          v-if="scope.row.ticket_priority"
        >
          {{ TicketUtils.getDictName(dataCache.priorityOptions, scope.row.ticket_priority) }}
        </el-tag>
        <span v-else class="text-gray-400">-</span>
      </template>
    </catch-table>

    <!-- 工单详情弹窗 -->
    <el-dialog 
      v-model="dialogState.ticketDetail" 
      title="详情" 
      width="90%"
      :before-close="() => closeDialog('ticketDetail')"
    >
      <TicketDetailViewer 
        v-if="dialogState.ticketDetail && currentData.ticketRow" 
        :ticket="currentData.ticketRow" 
      />
    </el-dialog>

    <!-- 表单数据查看弹窗 -->
    <el-dialog 
      v-model="dialogState.formData" 
      title="流程" 
      width="80%" 
      :before-close="() => closeDialog('formData')"
    >
      <FormDataViewer 
        v-if="dialogState.formData && currentData.formData" 
        :form-data="currentData.formData"
        :template-id="currentData.templateId" 
      />
    </el-dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, computed, reactive } from 'vue'
import { ElMessageBox, ElMessage } from 'element-plus'
import { View, Document, Delete } from '@element-plus/icons-vue'
import http from '@/support/http'
import FormDataViewer from './components/FormDataViewer.vue'
import TicketDetailViewer from './components/TicketDetailViewer.vue'

// ===== 常量定义 =====
const API_ENDPOINT = "tickets/tickets"

// ===== 类型定义 =====
interface DialogState {
  ticketDetail: boolean
  formData: boolean
}

interface CurrentData {
  ticketRow: any
  formData: string | undefined
  templateId: number | undefined
}

interface DataCache {
  users: Map<number, string>
  statusOptions: Map<number, string>
  priorityOptions: Map<number, string>
  loading: boolean
}

// ===== 响应式数据 =====
const dialogState = reactive<DialogState>({
  ticketDetail: false,
  formData: false
})

const currentData = reactive<CurrentData>({
  ticketRow: null,
  formData: undefined,
  templateId: undefined
})

const dataCache = reactive<DataCache>({
  users: new Map(),
  statusOptions: new Map(),
  priorityOptions: new Map(),
  loading: false
})

// ===== 数据服务 =====
class DataService {
  static async fetchUsers(cache: DataCache): Promise<void> {
    if (cache.loading) return
    
    cache.loading = true
    try {
      const userIds = Array.from({ length: 100 }, (_, i) => i + 1)
      const response = await http.get('/users/batch', { user_ids: userIds })
      
      if (response.data?.data) {
        cache.users.clear()
        response.data.data.forEach((user: any) => {
          if (user.id && user.nickname) {
            cache.users.set(user.id, user.nickname)
          }
        })
      }
    } catch (error) {
      console.error('获取用户列表失败:', error)
      ElMessage.error('获取用户列表失败')
    } finally {
      cache.loading = false
    }
  }

  static async fetchDictionaries(cache: DataCache): Promise<void> {
    try {
      const [statusResponse, priorityResponse] = await Promise.all([
        http.get('options/ticketStatus'),
        http.get('options/ticketPriority')
      ])
      
      if (statusResponse.data?.data) {
        statusResponse.data.data.forEach((item: any) => 
          cache.statusOptions.set(item.value, item.label)
        )
      }
      
      if (priorityResponse.data?.data) {
        priorityResponse.data.data.forEach((item: any) => 
          cache.priorityOptions.set(item.value, item.label)
        )
      }
    } catch (error) {
      console.error('获取字典数据失败:', error)
      ElMessage.error('获取字典数据失败')
    }
  }

  static async initializeAll(cache: DataCache): Promise<void> {
    await Promise.all([
      this.fetchUsers(cache),
      this.fetchDictionaries(cache)
    ])
  }
}

// ===== 工单工具类（统一所有工单相关操作） =====
class TicketUtils {
  // 用户名称格式化
  static getUserName(userId: number | string, userMap: Map<number, string>): string {
    if (!userId) return '-'
    
    const getSingleUserName = (id: string | number) => {
      const numId = typeof id === 'string' ? parseInt(id) : id
      return userMap.get(numId) || numId.toString()
    }

    if (typeof userId === 'string' && userId.includes(',')) {
      return userId.split(',').map(id => id.trim()).filter(id => id)
        .map(getSingleUserName).join(', ')
    }
    
    return getSingleUserName(userId)
  }

  // 字典名称获取
  static getDictName(map: Map<number, string>, value: number): string {
    return map.get(value) || value.toString()
  }

  // 时间格式化
  static formatTime(timestamp: number): string {
    return timestamp ? new Date(timestamp * 1000).toLocaleString() : '-'
  }

  // 获取当前处理人
  static getCurrentProcessor(row: any, userMap: Map<number, string>): string {
    try {
      if (row.closed_at) return '已完成'

      const acceptUserId = row.ticket_process_position || row.ticket_node_accept
      if (!acceptUserId) return '待分配受理人'

      if (!row.ticket_process_at) {
        return this.getUserName(acceptUserId, userMap)
      }

      if (row.ticket_process_at) {
        const currentProcessorId = row.ticket_process_position
        if (currentProcessorId) {
          const currentNodeId = row.ticket_node_id || 1
          const userName = this.getUserName(currentProcessorId, userMap)
          return `${userName} (节点${currentNodeId})`
        }

        const processUserIds = row.ticket_node_process
        const currentNodeId = row.ticket_node_id || 1
        
        if (processUserIds) {
          const userIds = typeof processUserIds === 'string' 
            ? processUserIds.split(',').map(id => id.trim()).filter(id => id)
            : [processUserIds]
          
          const currentUserIndex = currentNodeId - 1
          if (currentUserIndex >= 0 && currentUserIndex < userIds.length) {
            const currentUserId = userIds[currentUserIndex]
            const userName = this.getUserName(currentUserId, userMap)
            return `${userName} (节点${currentNodeId})`
          }
        }
        
        return `处理中 (节点${currentNodeId})`
      }

      return '状态未知'
    } catch (error) {
      console.error('计算当前处理人失败:', error)
      return '计算失败'
    }
  }

  // 计算受理超期状态
  static calculateAcceptOverdueStatus(row: any): string {
    try {
      if (row.closed_at) return '正常'
      if (!row.ticket_accept_days || row.ticket_accept_days <= 0) return '正常'

      const createdTime = new Date(row.created_at).getTime()
      const acceptDeadline = createdTime + (row.ticket_accept_days * 24 * 60 * 60 * 1000)
      const currentTime = Date.now()

      const acceptUserId = row.ticket_process_position || row.ticket_node_accept
      if (!acceptUserId) {
        return currentTime > acceptDeadline ? '超期' : '正常'
      }

      if (row.ticket_process_at) {
        return '正常'
      }

      return currentTime > acceptDeadline ? '超期' : '正常'
    } catch (error) {
      console.error('计算受理超期状态失败:', error)
      return '正常'
    }
  }

  // 计算处理超期状态
  static calculateProcessOverdueStatus(row: any): string {
    try {
      if (row.closed_at) return '正常'
      if (!row.ticket_accept_days || !row.ticket_process_days || 
          row.ticket_accept_days <= 0 || row.ticket_process_days <= 0) {
        return '正常'
      }

      const createdTime = new Date(row.created_at).getTime()
      const totalDays = row.ticket_accept_days + row.ticket_process_days
      const processDeadline = createdTime + (totalDays * 24 * 60 * 60 * 1000)
      const currentTime = Date.now()

      if (row.ticket_process_at) {
        const processTime = row.ticket_process_at * 1000
        return processTime > processDeadline ? '超期' : '正常'
      }

      return currentTime > processDeadline ? '超期' : '正常'
    } catch (error) {
      console.error('计算处理超期状态失败:', error)
      return '正常'
    }
  }

  // 删除工单
  static async deleteTicket(row: any): Promise<void> {
    try {
      await ElMessageBox.confirm(
        `确定要删除工单"${row.ticket_name || row.ticket_no}"吗？此操作不可恢复。`,
        '删除确认',
        { 
          confirmButtonText: '确定删除', 
          cancelButtonText: '取消', 
          type: 'warning', 
          confirmButtonClass: 'el-button--danger' 
        }
      )
      
      const response = await http.delete(`${API_ENDPOINT}/${row.id}`)
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
}

// ===== 事件处理函数 =====
const handleViewTicketDetail = (row: any) => {
  currentData.ticketRow = row
  dialogState.ticketDetail = true
}

const handleViewFormData = (row: any) => {
  currentData.formData = row.ticket_data
  currentData.templateId = row.ticket_template
  dialogState.formData = true
}

const handleDelete = (row: any) => {
  TicketUtils.deleteTicket(row)
}

const closeDialog = (dialogType: keyof DialogState) => {
  dialogState[dialogType] = false
  
  switch (dialogType) {
    case 'ticketDetail':
      currentData.ticketRow = null
      break
    case 'formData':
      currentData.formData = undefined
      currentData.templateId = undefined
      break
  }
}

// ===== 工具函数 =====
const getProcessorTagType = (row: any): string => {
  if (row.closed_at) return 'success'
  if (row.ticket_process_at) return 'primary'
  return 'info'
}

const getOverdueTagType = (status: string): string => {
  return status === '超期' ? 'danger' : 'success'
}

// 获取状态标签类型
const getStatusTagType = (status: number): string => {
  // 先检查状态是否存在且为有效数字
  if (!status || typeof status !== 'number') {
    return 'info'
  }
  
  const statusTagTypes: Record<number, string> = {
    1: 'warning',  // 待处理 - 橙色
    2: 'primary',  // 处理中 - 蓝色
    3: 'success',  // 已完成 - 绿色
    4: 'info',     // 已关闭 - 灰色
    5: 'danger'    // 已取消 - 红色
  }
  return statusTagTypes[status] || 'info'
}

// 获取优先级标签类型
const getPriorityTagType = (priority: number): string => {
  // 先检查优先级是否存在且为有效数字
  if (!priority || typeof priority !== 'number') {
    return 'info'
  }
  
  const priorityTagTypes: Record<number, string> = {
    1: 'info',     // 低 - 灰色
    2: 'success',  // 中 - 绿色  
    3: 'warning',  // 高 - 橙色
    4: 'danger'    // 特 - 红色
  }
  return priorityTagTypes[priority] || 'info'
}

// ===== 初始化 =====
onMounted(() => {
  DataService.initializeAll(dataCache)
})



// ===== 计算属性 =====
const searchForm = computed(() => [
  { type: 'input', name: 'ticket_no', label: '工单编号', placeholder: '请输入工单编号' },
  { type: 'input', name: 'ticket_name', label: '工单标题', placeholder: '请输入工单标题' },
  { 
    type: 'select', 
    name: 'ticket_status', 
    label: '状态', 
    placeholder: '请选择工单状态',
    options: Array.from(dataCache.statusOptions.entries()).map(([value, label]) => ({ value, label }))
  },
  { 
    type: 'select', 
    name: 'ticket_priority', 
    label: '优先级', 
    placeholder: '请选择优先级',
    options: Array.from(dataCache.priorityOptions.entries()).map(([value, label]) => ({ value, label }))
  },
  { 
    type: 'select', 
    name: 'ticket_promoter', 
    label: '发起人', 
    placeholder: '请选择发起人',
    options: Array.from(dataCache.users.entries()).map(([value, label]) => ({ value, label }))
  },
  { 
    type: 'select', 
    name: 'ticket_process_position', 
    label: '受理人', 
    placeholder: '请选择受理人',
    options: Array.from(dataCache.users.entries()).map(([value, label]) => ({ value, label }))
  },
  { 
    type: 'select', 
    name: 'current_processor', 
    label: '当前处理人', 
    placeholder: '请选择当前处理人',
    options: Array.from(dataCache.users.entries()).map(([value, label]) => ({ value, label }))
  },
  { type: 'date', name: 'created_at', label: '创建时间', placeholder: '请选择创建时间' },
  { type: 'date', name: 'closed_at', label: '关闭时间', placeholder: '请选择关闭时间' }
])

const columns = computed(() => [
  { prop: 'id', label: '编号', width: 80, align: 'center' },
  { prop: 'ticket_no', label: '工单编号', width: 140, align: 'center' },
  { prop: 'ticket_name', label: '工单标题', width: 200, showOverflowTooltip: true },
  { 
    prop: 'ticket_status', 
    label: '状态',
    width: 100,
    align: 'center',
    slot: 'ticket_status'
  },
  { 
    prop: 'ticket_priority', 
    label: '优先级',
    width: 90,
    align: 'center',
    slot: 'ticket_priority'
  },
  {
    prop: 'current_processor',
    label: '当前处理人',
    width: 150,
    align: 'center',
    slot: 'current_processor'
  },
  {
    prop: 'accept_overdue_status',
    label: '受理状态',
    width: 100,
    align: 'center',
    slot: 'accept_overdue_status'
  },
  {
    prop: 'process_overdue_status',
    label: '处理状态',
    width: 100,
    align: 'center',
    slot: 'process_overdue_status'
  },
  { 
    prop: 'ticket_promoter', 
    label: '发起人',
    width: 100,
    filter: (userId: number) => userId ? TicketUtils.getUserName(userId, dataCache.users) : '-'
  },
  { 
    prop: 'ticket_process_position', 
    label: '受理人',
    width: 100,
    filter: (userId: number) => userId ? TicketUtils.getUserName(userId, dataCache.users) : '-'
  },
  { 
    prop: 'ticket_node_process', 
    label: '处理人',
    width: 200,
    showOverflowTooltip: true,
    filter: (userIds: string) => userIds ? TicketUtils.getUserName(userIds, dataCache.users) : '-'
  },
  { prop: 'created_at', label: '创建时间', width: 160 },
  { 
    prop: 'closed_at', 
    label: '关闭时间',
    width: 160,
    filter: TicketUtils.formatTime
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

// ===== 暴露给模板的数据 =====
const api = API_ENDPOINT
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