<template>
  <div class="ticket-detail-viewer">
    <el-row :gutter="20">
      <!-- 左侧：基本信息 -->
      <el-col :span="12">
        <el-card class="detail-card">
          <template #header>
            <div class="card-header">
              <span>工单基本信息</span>
              <el-tag :type="getStatusTagType(ticket.ticket_status)">
                {{ getStatusName(ticket.ticket_status) }}
              </el-tag>
            </div>
          </template>
          
          <el-descriptions :column="1" border>
            <el-descriptions-item label="工单编号">
              <el-tag type="info">{{ ticket.ticket_no }}</el-tag>
            </el-descriptions-item>
            <el-descriptions-item label="工单标题">
              <strong>{{ ticket.ticket_name }}</strong>
            </el-descriptions-item>
            <el-descriptions-item label="工单状态">
              <el-tag :type="getStatusTagType(ticket.ticket_status)">
                {{ getStatusName(ticket.ticket_status) }}
              </el-tag>
            </el-descriptions-item>
            <el-descriptions-item label="优先级">
              <el-tag :type="getPriorityTagType(ticket.ticket_priority)">
                {{ getPriorityName(ticket.ticket_priority) }}
              </el-tag>
            </el-descriptions-item>
            <el-descriptions-item label="关联模板">
              <div v-if="ticket.ticket_template">
                <el-button 
                  type="primary" 
                  size="small" 
                  @click="viewTemplate"
                  :loading="templateLoading"
                >
                  <el-icon><Document /></el-icon>
                  查看模板 (ID: {{ ticket.ticket_template }})
                </el-button>
              </div>
              <span v-else>无关联模板</span>
            </el-descriptions-item>
            <el-descriptions-item label="受理人">
              <div v-if="ticket.ticket_node_accept">
                <el-avatar :size="24" class="mr-2">
                  {{ getUserName(ticket.ticket_node_accept).charAt(0) }}
                </el-avatar>
                {{ getUserName(ticket.ticket_node_accept) }}
              </div>
              <span v-else>未指定</span>
            </el-descriptions-item>
          </el-descriptions>
        </el-card>

        <!-- 时间信息 -->
        <el-card class="detail-card mt-4">
          <template #header>
            <div class="card-header">
              <span>时间记录</span>
            </div>
          </template>
          
          <el-timeline>
            <el-timeline-item timestamp="创建时间" :hollow="false">
              <el-tag size="small">{{ formatDateTime(ticket.created_at) }}</el-tag>
            </el-timeline-item>
            <el-timeline-item timestamp="最后更新" :hollow="false" v-if="ticket.updated_at">
              <el-tag type="warning" size="small">{{ formatDateTime(ticket.updated_at) }}</el-tag>
            </el-timeline-item>
            <el-timeline-item timestamp="关闭时间" :hollow="false" v-if="ticket.closed_at">
              <el-tag type="success" size="small">{{ formatDateTime(ticket.closed_at) }}</el-tag>
            </el-timeline-item>
          </el-timeline>
        </el-card>
      </el-col>

      <!-- 右侧：表单数据详情 -->
      <el-col :span="12">
        <el-card class="detail-card">
          <template #header>
            <div class="card-header">
              <span>表单数据详情</span>
              <el-button 
                size="small" 
                @click="viewFormData"
                v-if="ticket.ticket_data"
              >
                <el-icon><View /></el-icon>
                详细查看
              </el-button>
            </div>
          </template>
          
          <div v-if="parsedFormData" class="form-data-preview">
            <div 
              v-for="(value, key) in parsedFormData" 
              :key="key"
              class="data-item"
            >
              <div class="data-label">{{ getFieldLabel(key) }}:</div>
              <div class="data-value">
                <el-tag 
                  v-if="Array.isArray(value)"
                  v-for="(item, index) in value.slice(0, 3)" 
                  :key="index"
                  size="small"
                  class="mr-1"
                >
                  {{ item }}
                </el-tag>
                <span v-if="Array.isArray(value) && value.length > 3" class="more-text">
                  ... 等{{ value.length }}项
                </span>
                <span v-else-if="!Array.isArray(value)">
                  {{ formatValue(value) }}
                </span>
              </div>
            </div>
          </div>
          
          <el-empty v-else description="暂无表单数据" />
        </el-card>

        <!-- 操作历史记录（模拟） -->
        <el-card class="detail-card mt-4">
          <template #header>
            <div class="card-header">
              <span>操作记录</span>
            </div>
          </template>
          
          <el-timeline>
            <el-timeline-item 
              :timestamp="formatDateTime(ticket.created_at)"
              icon="Plus"
              type="primary"
            >
              工单已创建
            </el-timeline-item>
            <el-timeline-item 
              v-if="ticket.ticket_node_accept"
              :timestamp="formatDateTime(ticket.updated_at || ticket.created_at)"
              icon="User"
              type="success"
            >
              已分配给 {{ getUserName(ticket.ticket_node_accept) }}
            </el-timeline-item>
            <el-timeline-item 
              v-if="ticket.closed_at"
              :timestamp="formatDateTime(ticket.closed_at)"
              icon="Check"
              type="success"
            >
              工单已关闭
            </el-timeline-item>
          </el-timeline>
        </el-card>
      </el-col>
    </el-row>

    <!-- 模板查看弹窗 -->
    <el-dialog
      v-model="templateDialogVisible"
      title="关联模板详情"
      width="80%"
      :before-close="handleTemplateDialogClose"
    >
      <TicketTemplate 
        v-if="templateDialogVisible && ticket.ticket_template"
        mode="detail"
        :template-id="ticket.ticket_template"
        :show-actions="false"
      />
    </el-dialog>

    <!-- 表单数据查看弹窗 -->
    <el-dialog
      v-model="formDataDialogVisible"
      title="表单数据详情"
      width="70%"
      :before-close="handleFormDataDialogClose"
    >
      <FormDataViewer 
        v-if="formDataDialogVisible && ticket.ticket_data"
        :form-data="ticket.ticket_data"
        :template-id="ticket.ticket_template"
      />
    </el-dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import { Document, View } from '@element-plus/icons-vue'
import TicketTemplate from '@/components/ticket/TicketTemplate.vue'
import FormDataViewer from './FormDataViewer.vue'

interface Props {
  ticket: any
}

const props = defineProps<Props>()

const templateLoading = ref(false)
const templateDialogVisible = ref(false)
const formDataDialogVisible = ref(false)

// 解析表单数据
const parsedFormData = computed(() => {
  if (!props.ticket.ticket_data) return null
  
  try {
    return typeof props.ticket.ticket_data === 'string' 
      ? JSON.parse(props.ticket.ticket_data)
      : props.ticket.ticket_data
  } catch (error) {
    console.error('解析表单数据失败:', error)
    return null
  }
})

// 获取状态名称（这里应该与父组件保持一致）
const getStatusName = (statusValue: number): string => {
  const statusMap: Record<number, string> = {
    1: '待处理',
    2: '处理中',
    3: '已完成',
    4: '已关闭',
    5: '已取消'
  }
  return statusMap[statusValue] || `状态${statusValue}`
}

// 获取优先级名称
const getPriorityName = (priorityValue: number): string => {
  const priorityMap: Record<number, string> = {
    1: '低',
    2: '中',
    3: '高',
    4: '紧急'
  }
  return priorityMap[priorityValue] || `优先级${priorityValue}`
}

// 获取用户名称
const getUserName = (userId: number): string => {
  // 这里应该从父组件或全局状态获取用户映射
  return `用户${userId}`
}

// 获取状态标签类型
const getStatusTagType = (statusValue: number): string => {
  const statusTagTypes: Record<number, string> = {
    1: 'warning',
    2: 'primary',
    3: 'success',
    4: 'info',
    5: 'danger'
  }
  return statusTagTypes[statusValue] || 'info'
}

// 获取优先级标签类型
const getPriorityTagType = (priorityValue: number): string => {
  const priorityTagTypes: Record<number, string> = {
    1: 'success',
    2: 'primary',
    3: 'warning',
    4: 'danger'
  }
  return priorityTagTypes[priorityValue] || 'primary'
}

// 获取字段标签
const getFieldLabel = (key: string): string => {
  const labelMap: Record<string, string> = {
    'name': '姓名',
    'phone': '电话',
    'email': '邮箱',
    'company': '公司',
    'department': '部门',
    'title': '标题',
    'description': '描述',
    'priority': '优先级',
    'category': '分类',
    'attachment': '附件'
  }
  return labelMap[key] || key
}

// 格式化值
const formatValue = (value: any): string => {
  if (value === null || value === undefined) return '-'
  if (typeof value === 'boolean') return value ? '是' : '否'
  if (typeof value === 'object') return '[对象]'
  return String(value).length > 50 ? String(value).substring(0, 50) + '...' : String(value)
}

// 格式化日期时间
const formatDateTime = (dateTime: string): string => {
  if (!dateTime) return '-'
  return new Date(dateTime).toLocaleString('zh-CN')
}

// 查看模板
const viewTemplate = () => {
  templateDialogVisible.value = true
}

// 查看表单数据
const viewFormData = () => {
  formDataDialogVisible.value = true
}

// 弹窗关闭处理
const handleTemplateDialogClose = () => {
  templateDialogVisible.value = false
}

const handleFormDataDialogClose = () => {
  formDataDialogVisible.value = false
}
</script>

<style scoped>
.ticket-detail-viewer {
  max-height: 80vh;
  overflow-y: auto;
}

.detail-card {
  height: fit-content;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.form-data-preview {
  max-height: 40vh;
  overflow-y: auto;
}

.data-item {
  display: flex;
  margin-bottom: 12px;
  padding: 8px;
  border-radius: 4px;
  background-color: var(--el-fill-color-lighter);
}

.data-label {
  min-width: 100px;
  font-weight: 500;
  color: var(--el-text-color-regular);
}

.data-value {
  flex: 1;
  color: var(--el-text-color-primary);
}

.mr-1 {
  margin-right: 4px;
}

.mr-2 {
  margin-right: 8px;
}

.more-text {
  color: var(--el-text-color-placeholder);
  font-size: 12px;
}
</style>
