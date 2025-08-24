<template>
  <div>
    <catch-table
      :columns="columns"
      :api="api"
      :operation="false"
      :show-header="true"
      :search-form="searchForm"
    >
      <!-- 自定义操作列 -->
      <template #operate="scope">
        <div class="action-buttons">
          <el-button 
            size="small" 
            type="primary" 
            text 
            @click="handleViewTicketDetail(scope.row)"
            class="action-btn"
          >
            <el-icon size="14">
              <View />
            </el-icon>
            查看详情
          </el-button>
          
          <el-button 
            size="small" 
            type="success" 
            text 
            @click="handleViewFormData(scope.row)"
            v-if="scope.row.ticket_data"
            class="action-btn"
          >
            <el-icon size="14">
              <Document />
            </el-icon>
            表单数据
          </el-button>
          
          <el-button 
            size="small" 
            type="info" 
            text 
            @click="handleViewTemplate(scope.row)"
            v-if="scope.row.ticket_template"
            class="action-btn"
          >
            <el-icon size="14">
              <Files />
            </el-icon>
            关联模板
          </el-button>
          
          <el-divider direction="vertical" />
          
          <el-button 
            size="small" 
            type="danger" 
            text 
            @click="handleDelete(scope.row)"
            class="action-btn"
          >
            <el-icon size="14">
              <Delete />
            </el-icon>
            删除
          </el-button>
        </div>
      </template>
    </catch-table>

    <!-- 工单详情弹窗 -->
    <el-dialog
      v-model="ticketDetailDialogVisible"
      title="工单详情"
      width="90%"
      :before-close="handleTicketDetailDialogClose"
    >
      <TicketDetailViewer 
        v-if="ticketDetailDialogVisible && currentTicketRow"
        :ticket="currentTicketRow"
      />
    </el-dialog>

    <!-- 表单数据查看弹窗 -->
    <el-dialog
      v-model="formDataDialogVisible"
      title="表单数据详情"
      width="80%"
      :before-close="handleFormDataDialogClose"
    >
      <FormDataViewer 
        v-if="formDataDialogVisible && currentFormData"
        :form-data="currentFormData"
        :template-id="currentTemplateId"
      />
    </el-dialog>

    <!-- 模板查看弹窗 -->
    <el-dialog
      v-model="templateDialogVisible"
      title="关联模板详情"
      width="80%"
      :before-close="handleTemplateDialogClose"
    >
      <TicketTemplate 
        v-if="templateDialogVisible && currentTemplateId"
        mode="detail"
        :template-id="currentTemplateId"
        :show-actions="false"
      />
    </el-dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue'
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
    const response = await http.get('/users')
    if (response.data && response.data.data) {
      const users = response.data.data
      users.forEach((user: any) => {
        userMap.value.set(user.id, user.username)
      })
    }
  } catch (error) {
    console.error('获取用户列表失败:', error)
  } finally {
    loading.value = false
  }
}

// 获取用户名称
const getUserName = (userId: number): string => {
  return userMap.value.get(userId) || userId.toString()
}

// 获取字典数据
const fetchDictionaries = async () => {
  try {
    // 获取工单状态字典
    const statusResponse = await http.get('options/ticketStatus')
    if (statusResponse.data && statusResponse.data.data) {
      statusResponse.data.data.forEach((item: any) => {
        statusOptions.value.set(item.value, item.label)
      })
      statusOptionsLoaded.value = true
    }

    // 获取优先级字典
    const priorityResponse = await http.get('options/ticketPriority')
    if (priorityResponse.data && priorityResponse.data.data) {
      priorityResponse.data.data.forEach((item: any) => {
        priorityOptions.value.set(item.value, item.label)
      })
      priorityOptionsLoaded.value = true
    }
  } catch (error) {
    console.error('获取字典数据失败:', error)
  }
}

// 获取状态名称
const getStatusName = (statusValue: number): string => {
  return statusOptions.value.get(statusValue) || statusValue.toString()
}

// 获取优先级名称
const getPriorityName = (priorityValue: number): string => {
  return priorityOptions.value.get(priorityValue) || priorityValue.toString()
}

// 处理查看工单详情
const handleViewTicketDetail = (row: any) => {
  currentTicketRow.value = row
  ticketDetailDialogVisible.value = true
}

// 处理查看表单数据
const handleViewFormData = (row: any) => {
  currentFormData.value = row.ticket_data
  currentTemplateId.value = row.ticket_template
  formDataDialogVisible.value = true
}

// 处理查看模板
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
      {
        confirmButtonText: '确定删除',
        cancelButtonText: '取消',
        type: 'warning',
        confirmButtonClass: 'el-button--danger',
      }
    )
    
    // 调用删除API
    const response = await http.delete(`${api}/${row.id}`)
    if (response.data && response.data.code === 200) {
      ElMessage.success('工单删除成功')
      // 刷新列表
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

// 弹窗关闭处理方法
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

// 搜索表单配置
const searchForm = [
  {
    type: 'input',
    name: 'ticket_no',
    label: '工单编号',
    placeholder: '请输入工单编号'
  },
  {
    type: 'input',
    name: 'ticket_name',
    label: '工单标题',
    placeholder: '请输入工单标题'
  },
  {
    type: 'select',
    name: 'ticket_status',
    label: '工单状态',
    placeholder: '请选择工单状态',
    api: 'ticketStatus'
  },
  {
    type: 'select',
    name: 'ticket_priority',
    label: '优先级',
    placeholder: '请选择优先级',
    api: 'ticketPriority'
  },
  {
    type: 'select',
    name: 'ticket_promoter',
    label: '发起人',
    placeholder: '请选择发起人',
    api: 'users'
  },
  {
    type: 'select',
    name: 'ticket_node_accept',
    label: '受理人',
    placeholder: '请选择受理人',
    api: 'users'
  },
  {
    type: 'select',
    name: 'ticket_accept_overdue',
    label: '受理超期',
    placeholder: '请选择受理超期状态',
    options: [
      { label: '正常', value: 0 },
      { label: '超期', value: 1 }
    ]
  },
  {
    type: 'select',
    name: 'ticket_process_overdue',
    label: '处理超期',
    placeholder: '请选择处理超期状态',
    options: [
      { label: '正常', value: 0 },
      { label: '超期', value: 1 }
    ]
  },
  {
    type: 'date',
    name: 'created_at',
    label: '创建时间',
    placeholder: '请选择创建时间'
  },
  {
    type: 'date',
    name: 'ticket_accept_at',
    label: '受理时间',
    placeholder: '请选择受理时间'
  },
  {
    type: 'date',
    name: 'closed_at',
    label: '关闭时间',
    placeholder: '请选择关闭时间'
  }
]

// table columns - 优化后的列配置
const columns = [
  {
    prop: 'id',
    label: '编号',
    width: 80,
  },
  {
    prop: 'ticket_no',
    label: '工单编号',
    width: 140,
  },
  {
    prop: 'ticket_name',
    label: '工单标题',
    width: 200,
    showOverflowTooltip: true,
  },
  {
    prop: 'ticket_status',
    label: '状态',
    width: 100,
    align: 'center',
    tags: ['primary', 'warning', 'danger', 'info', 'success'],
    filter: (value: number) => {
      return getStatusName(value)
    }
  },
  {
    prop: 'ticket_priority',
    label: '优先级',
    width: 90,
    align: 'center',
    tags: ['success', 'primary', 'warning', 'danger'],
    filter: (value: number) => {
      return getPriorityName(value)
    }
  },
  {
    prop: 'ticket_promoter',
    label: '发起人',
    width: 100,
    filter: (userId: number) => {
      return userId ? getUserName(userId) : '-'
    }
  },
  {
    prop: 'ticket_node_accept',
    label: '受理人',
    width: 100,
    filter: (userId: number) => {
      return userId ? getUserName(userId) : '-'
    }
  },
  {
    prop: 'ticket_accept_at',
    label: '受理时间',
    width: 160,
    filter: (timestamp: number) => {
      return timestamp ? new Date(timestamp * 1000).toLocaleString() : '-'
    }
  },
  {
    prop: 'ticket_accept_overdue',
    label: '受理超期',
    width: 90,
    align: 'center',
    tags: ['success', 'danger'],
    filter: (value: number) => {
      return value === 1 ? '超期' : '正常'
    }
  },
  {
    prop: 'ticket_process_at',
    label: '处理时间',
    width: 160,
    filter: (timestamp: number) => {
      return timestamp ? new Date(timestamp * 1000).toLocaleString() : '-'
    }
  },
  {
    prop: 'ticket_process_overdue',
    label: '处理超期',
    width: 90,
    align: 'center',
    tags: ['success', 'danger'],
    filter: (value: number) => {
      return value === 1 ? '超期' : '正常'
    }
  },
  {
    prop: 'created_at',
    label: '创建时间',
    width: 160,
  },
  {
    prop: 'closed_at',
    label: '关闭时间',
    width: 160,
    filter: (timestamp: number) => {
      return timestamp ? new Date(timestamp * 1000).toLocaleString() : '-'
    }
  },
  {
    type: 'operate',
    label: '操作',
    width: 280,
    fixed: 'right',
    update: false,
    destroy: false,
  }
]
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