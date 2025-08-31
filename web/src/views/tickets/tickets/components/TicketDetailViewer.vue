<template>
  <div class="ticket-detail-container">
    <el-row :gutter="20">
      <!-- 左侧：工单基本信息和模板信息 -->
      <el-col :xs="24" :sm="24" :md="14" :lg="14">
        <!-- 工单基本信息 -->
        <el-card class="detail-card">
          <template #header>
            <div class="card-header">
              <span>工单基本信息</span>
              <el-tag :type="getStatusTagType(ticketDetail.ticket_status)">
                {{ getStatusName(ticketDetail.ticket_status) }}
              </el-tag>
            </div>
          </template>
          
          <el-descriptions :column="2" border>
            <el-descriptions-item label="工单编号" :span="2">
              <el-tag type="info">{{ ticketDetail.ticket_no }}</el-tag>
            </el-descriptions-item>
            <el-descriptions-item label="工单标题" :span="2">
              <strong>{{ ticketDetail.ticket_name }}</strong>
            </el-descriptions-item>
            <el-descriptions-item label="工单状态">
              <el-tag :type="getStatusTagType(ticketDetail.ticket_status)">
                {{ getStatusName(ticketDetail.ticket_status) }}
              </el-tag>
            </el-descriptions-item>
            <el-descriptions-item label="优先级">
              <el-tag :type="getPriorityTagType(ticketDetail.ticket_priority)">
                {{ getPriorityName(ticketDetail.ticket_priority) }}
              </el-tag>
            </el-descriptions-item>
            <el-descriptions-item label="发起人" :span="1">
              <div v-if="ticketDetail.ticket_promoter">
                <el-avatar :size="24" class="mr-2">
                  {{ getPromoterName(ticketDetail.ticket_promoter).charAt(0) }}
                </el-avatar>
                {{ getPromoterName(ticketDetail.ticket_promoter) }}
              </div>
              <span v-else>未知用户</span>
            </el-descriptions-item>
            <el-descriptions-item label="受理人" :span="1">
              <div v-if="ticketDetail.ticket_node_accept">
                <el-avatar :size="24" class="mr-2">
                  {{ getAcceptorName(ticketDetail.ticket_node_accept).charAt(0) }}
                </el-avatar>
                {{ getAcceptorName(ticketDetail.ticket_node_accept) }}
              </div>
              <span v-else>未指定</span>
            </el-descriptions-item>
          </el-descriptions>
        </el-card>

        <!-- 工单模板信息 -->
        <el-card class="detail-card mt-4" v-if="templateInfo">
          <template #header>
            <div class="card-header">
              <span>模板信息</span>
              <el-button 
                type="primary" 
                size="small" 
                @click="showTemplateDetail = true"
              >
                <el-icon><Document /></el-icon>
                查看完整模板
              </el-button>
            </div>
          </template>
          
          <el-descriptions :column="2" border>
            <el-descriptions-item label="模板名称" :span="2">
              <strong>{{ templateInfo.ticket_name }}</strong>
            </el-descriptions-item>
            <el-descriptions-item label="模板描述" :span="2" v-if="templateInfo.ticket_description">
              {{ templateInfo.ticket_description }}
            </el-descriptions-item>
            <el-descriptions-item label="受理天数">
              {{ templateInfo.ticket_accept_days }} 天
            </el-descriptions-item>
            <el-descriptions-item label="处理天数">
              {{ templateInfo.ticket_process_days }} 天
            </el-descriptions-item>
          </el-descriptions>
        </el-card>
        <!-- 用户提交的表单数据 -->
        <el-card class="detail-card mt-4">
          <template #header>
            <div class="card-header">
              <span>用户提交内容</span>
              <el-button 
                v-if="parsedFormData"
                type="primary" 
                size="small" 
                @click="showFormDataDetail = true"
              >
                <el-icon><View /></el-icon>
                详细查看
              </el-button>
            </div>
          </template>
          
          <div v-if="parsedFormData && Object.keys(parsedFormData).length > 0" class="form-data-preview">
            <div 
              v-for="(value, key) in parsedFormData" 
              :key="key"
              class="data-item"
            >
              <div class="data-label">{{ getFieldLabel(String(key)) }}:</div>
              <div class="data-value">
                <template v-if="Array.isArray(value)">
                  <el-tag 
                    v-for="(item, index) in value.slice(0, 3)" 
                    :key="index"
                    size="small"
                    class="mr-1"
                  >
                    {{ item }}
                  </el-tag>
                  <span v-if="value.length > 3" class="more-text">
                    ... 等{{ value.length }}项
                  </span>
                </template>
                <template v-else>
                  {{ formatValue(value) }}
                </template>
              </div>
            </div>
          </div>
          
          <el-empty v-else description="暂无提交数据" />
        </el-card>
      </el-col>

      <!-- 右侧：时间记录和回复内容 -->
      <el-col :xs="24" :sm="24" :md="10" :lg="10">
        <!-- 时间记录 -->
        <el-card class="detail-card">
          <template #header>
            <div class="card-header">
              <span>时间记录</span>
            </div>
          </template>
          
          <el-timeline>
            <el-timeline-item 
              :timestamp="formatDateTime(ticketDetail.created_at)"
              icon="Plus"
              type="primary"
            >
              工单已创建
            </el-timeline-item>
            <el-timeline-item 
              v-if="ticketDetail.ticket_accept_at"
              :timestamp="formatDateTime(ticketDetail.ticket_accept_at)"
              icon="User"
              type="success"
            >
              工单已受理
            </el-timeline-item>
            <el-timeline-item 
              v-if="ticketDetail.ticket_process_at"
              :timestamp="formatDateTime(ticketDetail.ticket_process_at)"
              icon="Setting"
              type="warning"
            >
              开始处理
            </el-timeline-item>
            <el-timeline-item 
              v-if="ticketDetail.closed_at"
              :timestamp="formatDateTime(ticketDetail.closed_at)"
              icon="Check"
              type="success"
            >
              工单已关闭
            </el-timeline-item>
          </el-timeline>
        </el-card>

        <!-- 工单回复 -->
        <TicketReplyList 
          class="mt-4"
          :ticket-id="ticketDetail.id" 
          :replies="replies"
          :loading="repliesLoading"
          @refresh="loadReplies"
        />

        <!-- 回复表单 -->
        <TicketReplyForm 
          v-if="canReply"
          class="mt-4"
          :ticket-id="ticketDetail.id"
          @reply-success="handleReplySuccess"
        />
      </el-col>
    </el-row>

    <!-- 模板详情弹窗 -->
    <el-dialog
      v-model="showTemplateDetail"
      title="模板详情"
      width="80%"
      :before-close="() => showTemplateDetail = false"
    >
      <TicketTemplateViewer 
        v-if="showTemplateDetail && templateInfo"
        :template-data="templateInfo"
        mode="readonly"
      />
    </el-dialog>

    <!-- 表单数据详情弹窗 -->
    <el-dialog
      v-model="showFormDataDetail"
      title="用户提交内容详情"
      width="70%"
      :before-close="() => showFormDataDetail = false"
    >
      <TicketFormDataViewer 
        v-if="showFormDataDetail && parsedFormData"
        :form-data="parsedFormData"
        :template-fields="templateFields"
      />
    </el-dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted, inject } from 'vue'
import { ElMessage } from 'element-plus'
import { Document, View, Plus, User, Setting, Check } from '@element-plus/icons-vue'
import TicketReplyList from './TicketReplyList.vue'
import TicketReplyForm from './TicketReplyForm.vue'
import TicketTemplateViewer from './TicketTemplateViewer.vue'
import TicketFormDataViewer from './TicketFormDataViewer.vue'
import http from '@/support/http'

interface Props {
  ticketId: number | string
}

const props = defineProps<Props>()

// 响应式数据
const ticketDetail = ref<any>({})
const templateInfo = ref<any>(null)
const replies = ref<any[]>([])
const loading = ref(false)
const repliesLoading = ref(false)
const showTemplateDetail = ref(false)
const showFormDataDetail = ref(false)

// 计算属性
const parsedFormData = computed(() => {
  if (!ticketDetail.value.ticket_data) return null
  
  try {
    return typeof ticketDetail.value.ticket_data === 'string' 
      ? JSON.parse(ticketDetail.value.ticket_data)
      : ticketDetail.value.ticket_data
  } catch (error) {
    console.error('解析表单数据失败:', error)
    return null
  }
})

const templateFields = computed(() => {
  if (!templateInfo.value?.ticket_form) return []
  
  try {
    const formConfig = typeof templateInfo.value.ticket_form === 'string'
      ? JSON.parse(templateInfo.value.ticket_form)
      : templateInfo.value.ticket_form
    
    return Array.isArray(formConfig) ? formConfig : []
  } catch (error) {
    console.error('解析模板字段失败:', error)
    return []
  }
})

const canReply = computed(() => {
  // 只有状态为待处理、已受理、处理中的工单才能回复
  return [1, 2, 4].includes(ticketDetail.value.ticket_status)
})

// 方法
const loadTicketDetail = async () => {
  loading.value = true
  try {
    const response = await http.get(`tickets/tickets/${props.ticketId}`)
    ticketDetail.value = response.data
    
    // 如果有关联模板，加载模板信息
    if (response.data.ticket_template) {
      await loadTemplateInfo(response.data.ticket_template)
    }
  } catch (error) {
    console.error('加载工单详情失败:', error)
    ElMessage.error('加载工单详情失败')
  } finally {
    loading.value = false
  }
}

const loadTemplateInfo = async (templateId: number) => {
  try {
    const response = await http.get(`tickets/ticket/templates/${templateId}`)
    templateInfo.value = response.data
  } catch (error) {
    console.error('加载模板信息失败:', error)
  }
}

const loadReplies = async () => {
  repliesLoading.value = true
  try {
    const response = await http.get(`tickets/tickets/${props.ticketId}/replies`)
    replies.value = response.data || []
  } catch (error) {
    console.error('加载回复失败:', error)
    ElMessage.error('加载回复失败')
  } finally {
    repliesLoading.value = false
  }
}

const handleReplySuccess = () => {
  loadReplies()
  ElMessage.success('回复成功')
}

// 辅助方法
const getStatusName = (statusValue: number): string => {
  const statusMap: Record<number, string> = {
    1: '待处理',
    2: '已受理',
    3: '已拒绝',
    4: '处理中',
    6: '已完成'
  }
  return statusMap[statusValue] || `状态${statusValue}`
}


const getPriorityName = (priorityValue: number): string => {
  const priorityMap: Record<number, string> = {
    1: '低',
    2: '中',
    3: '高',
    4: '特'
  }
  return priorityMap[priorityValue] || `优先级${priorityValue}`
}

const getPromoterName = (userId: number): string => {
  // TODO: 从用户状态或接口获取用户名称
  return `用户${userId}`
}

const getAcceptorName = (userId: number): string => {
  // TODO: 从用户状态或接口获取用户名称
  return `受理人${userId}`
}

const getStatusTagType = (statusValue: number): string => {
  const statusTagTypes: Record<number, string> = {
    1: 'warning',
    2: 'primary', 
    3: 'danger',
    4: 'info',
    6: 'success'
  }
  return statusTagTypes[statusValue] || 'info'
}


const getPriorityTagType = (priorityValue: number): string => {
  const priorityTagTypes: Record<number, string> = {
    1: 'success',
    2: 'primary',
    3: 'warning',
    4: 'danger'
  }
  return priorityTagTypes[priorityValue] || 'primary'
}


const getFieldLabel = (key: string): string => {
  // 从模板字段中查找标签
  const field = templateFields.value.find((f: any) => f.name === key)
  if (field) return field.label || field.name
  
  // 默认标签映射
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


const formatValue = (value: any): string => {
  if (value === null || value === undefined) return '-'
  if (typeof value === 'boolean') return value ? '是' : '否'
  if (typeof value === 'object') return '[对象]'
  return String(value).length > 50 ? String(value).substring(0, 50) + '...' : String(value)
}

const formatDateTime = (timestamp: number | string): string => {
  if (!timestamp) return '-'
  
  const date = typeof timestamp === 'string' ? new Date(timestamp) : new Date(timestamp * 1000)
  return date.toLocaleString('zh-CN')
}

// 生命周期
onMounted(() => {
  loadTicketDetail()
  loadReplies()
})
</script>

<style scoped>
.ticket-detail-container {
  padding: 0;
}

.detail-card {
  height: fit-content;
  margin-bottom: 0;
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
  padding: 12px;
  border-radius: 6px;
  background-color: var(--el-fill-color-lighter);
  border-left: 3px solid var(--el-color-primary);
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
  font-style: italic;
}

.mt-4 {
  margin-top: 1rem;
}
</style>
