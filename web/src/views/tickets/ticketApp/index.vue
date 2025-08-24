<template>
  <div class="ticket-app">
    <!-- 主体内容 -->
    <div class="main-content">
      <el-row :gutter="12" class="content-row">
        <!-- 左侧：模板选择器 -->
        <el-col :xs="24" :sm="24" :md="10" :lg="8" :xl="6" class="template-section">
          <TemplateSelector 
            v-model:selected-template="selectedTemplate" 
            @template-select="handleTemplateSelect" 
            ref="templateSelectorRef" 
          />
        </el-col>
        <!-- 右侧：工单创建表单/空页引导 -->
        <el-col :xs="24" :sm="24" :md="14" :lg="16" :xl="18" class="form-section">
          <template v-if="selectedTemplate">
            <TicketDynamicForm 
              :template-data="selectedTemplate" 
              @submit="handleFormSubmit"
              submit-text="提交工单"
              :display-header="true"
              :display-meta="true"
            />
          </template>
          <template v-else>
            <div class="empty-panel">
              <el-empty description="暂无可用模板" :image-size="120">
                <el-space direction="vertical">
                  <el-button type="primary" @click="handleGoToTemplates">去添加模板</el-button>
                </el-space>
              </el-empty>
            </div>
          </template>
        </el-col>
      </el-row>
    </div>

    <!-- 成功提示对话框 -->
    <el-dialog 
      v-model="showSuccessDialog" 
      title="工单提交成功" 
      width="500px" 
      center 
      :show-close="false" 
      :close-on-click-modal="false" 
      :close-on-press-escape="false"
    >
      <div class="success-content">
        <el-result 
          icon="success" 
          title="工单创建成功" 
          :sub-title="`工单编号：${successTicket?.ticket_no || '未知'}`"
        >
          <!-- 调试信息 -->
          <div v-if="successTicket" style="margin-top: 16px; font-size: 12px; color: #999;">
            <p>调试信息：{{ JSON.stringify(successTicket) }}</p>
          </div>
          <template #extra>
            <el-space>
              <el-button @click="handleCancel">取消</el-button>
              <el-button type="primary" @click="handleViewTicket">查看工单</el-button>
            </el-space>
          </template>
        </el-result>
      </div>
    </el-dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import http from '@/support/http'

// 导入组件
import TemplateSelector from './components/TemplateSelector.vue'
import TicketDynamicForm from '@/components/ticket/TicketDynamicForm.vue'

// 类型定义
interface TemplateData {
  id: number
  ticket_name: string
  ticket_description: string
  ticket_form?: string
  ticket_accept: number
  ticket_process: string
  ticket_accept_days: number
  ticket_process_days: number
  ticket_is_active: number
  created_at: string
  updated_at: string
}

interface SubmittedTicket {
  id: number
  ticket_no: string
  title: string
  status: number
  priority: number
  process_position?: number
  created_at: string
}

// 路由
const router = useRouter()

// 响应式数据
const selectedTemplate = ref<TemplateData | null>(null)
const showSuccessDialog = ref(false)
const successTicket = ref<SubmittedTicket | null>(null)
const templateSelectorRef = ref()

// 调试信息
console.log('ticketApp 页面加载')

// 右侧空页行为
const handleGoToTemplates = () => {
  router.push('/ticket/templates')
}

const handleRefreshTemplates = () => {
  if (templateSelectorRef.value?.refreshTemplates) {
    templateSelectorRef.value.refreshTemplates()
  }
}

// 处理模板选择
const handleTemplateSelect = (template: TemplateData) => {
  selectedTemplate.value = template
}

// 处理表单提交
const handleFormSubmit = async (formData: any) => {
  try {
    const response = await http.post('tickets/app/submit', formData)
    console.log('工单提交响应:', response) // 调试日志
    
    if (response.data) {
      const ticket: SubmittedTicket = response.data.data || response.data
      console.log('工单数据:', ticket) // 调试日志
      handleSubmitSuccess(ticket)
      ElMessage.success('工单提交成功')
    } else {
      ElMessage.error('工单提交失败')
    }
  } catch (error: any) {
    console.error('工单提交失败:', error)
    const errorMessage = error.response?.data?.message || '工单提交失败，请稍后重试'
    ElMessage.error(errorMessage)
  }
}

// 处理工单提交成功
const handleSubmitSuccess = (ticket: SubmittedTicket) => {
  successTicket.value = ticket
  showSuccessDialog.value = true
}

// 取消操作
const handleCancel = () => {
  showSuccessDialog.value = false
  successTicket.value = null
}

// 查看工单列表
const handleViewTicket = () => {
  router.push('/tickets')
}
</script>

<style scoped>
.ticket-app {
  height: 100%;
  background-color: var(--el-bg-color-page);
}

.main-content {
  height: calc(100vh - 120px);
}

.content-row {
  height: 100%;
}

.template-section {
  height: 100%;
  overflow: hidden;
}

.form-section {
  height: 100%;
  overflow-y: auto;
  overflow-x: hidden;
}

.empty-panel {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.success-content {
  text-align: center;
}

/* 滚动条样式 */
.template-section::-webkit-scrollbar,
.form-section::-webkit-scrollbar {
  width: 6px;
}

.template-section::-webkit-scrollbar-track,
.form-section::-webkit-scrollbar-track {
  background: var(--el-border-color-lighter);
  border-radius: 3px;
}

.template-section::-webkit-scrollbar-thumb,
.form-section::-webkit-scrollbar-thumb {
  background: var(--el-color-primary-light-3);
  border-radius: 3px;
}

.template-section::-webkit-scrollbar-thumb:hover,
.form-section::-webkit-scrollbar-thumb:hover {
  background: var(--el-color-primary);
}

/* 响应式设计 */
@media (max-width: 1200px) {
  .content-row {
    height: auto;
    min-height: calc(100vh - 100px);
  }
  
  .template-section,
  .form-section {
    height: calc(100vh - 100px);
  }
}

@media (max-width: 768px) {
  .ticket-app {
    padding: 8px;
  }
  
  .main-content {
    height: auto;
    min-height: 100vh;
  }

  .content-row {
    height: auto;
  }
  
  .template-section {
    height: 80vh; 
    margin-bottom: 10px;
  }
  
  .form-section {
    height: auto;
  }
}
</style>
