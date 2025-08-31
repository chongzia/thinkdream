<template>
  <el-card class="reply-form-card">
    <template #header>
      <div class="card-header">
        <span>添加回复</span>
        <el-tag 
          v-if="currentAcceptStatus" 
          :type="getStatusTagType(currentAcceptStatus)"
          size="small"
        >
          {{ getAcceptStatusName(currentAcceptStatus) }}
        </el-tag>
      </div>
    </template>

    <el-form 
      :model="replyForm" 
      :rules="replyRules" 
      ref="replyFormRef"
      label-width="80px"
    >
      <!-- 引用回复显示 -->
      <div v-if="quotedReply" class="quoted-reply">
        <div class="quoted-header">
          <span>回复 {{ getUserDisplayName(quotedReply.ticket_user_id) }}:</span>
          <el-button 
            type="text" 
            size="small" 
            @click="clearQuotedReply"
          >
            <el-icon><Close /></el-icon>
          </el-button>
        </div>
        <div class="quoted-content">
          {{ quotedReply.ticket_content.substring(0, 100) }}
          <span v-if="quotedReply.ticket_content.length > 100">...</span>
        </div>
      </div>

      <!-- 回复状态选择 -->
      <el-form-item label="回复类型" prop="ticket_accept_status">
        <el-select 
          v-model="replyForm.ticket_accept_status" 
          placeholder="选择回复类型"
          @change="handleStatusChange"
        >
          <el-option 
            v-for="option in statusOptions" 
            :key="option.value"
            :label="option.label"
            :value="option.value"
          />
        </el-select>
      </el-form-item>

      <!-- 回复内容 -->
      <el-form-item label="回复内容" prop="ticket_content">
        <el-input
          v-model="replyForm.ticket_content"
          type="textarea"
          :rows="6"
          placeholder="请输入回复内容..."
          :maxlength="1000"
          show-word-limit
        />
      </el-form-item>

      <!-- 快速回复模板 -->
      <el-form-item label="快速回复">
        <div class="quick-reply-templates">
          <el-button 
            v-for="template in quickReplyTemplates"
            :key="template.id"
            size="small"
            type="text"
            @click="insertTemplate(template.content)"
          >
            {{ template.title }}
          </el-button>
        </div>
      </el-form-item>

      <!-- 操作按钮 -->
      <el-form-item>
        <div class="form-actions">
          <el-button 
            type="primary" 
            @click="submitReply"
            :loading="submitting"
          >
            <el-icon><Promotion /></el-icon>
            提交回复
          </el-button>
          <el-button @click="resetForm">
            <el-icon><Refresh /></el-icon>
            重置
          </el-button>
        </div>
      </el-form-item>
    </el-form>
  </el-card>
</template>

<script lang="ts" setup>
import { ref, reactive, computed, watch } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import { Close, Promotion, Refresh } from '@element-plus/icons-vue'
import http from '@/support/http'

interface Reply {
  id: number
  ticket_id: number
  ticket_accept_status: number
  ticket_content: string
  ticket_user_id: number
  created_at: number | string
  updated_at: number | string
  user?: {
    id: number
    username: string
  }
}

interface QuickReplyTemplate {
  id: number
  title: string
  content: string
}

interface Props {
  ticketId: number | string
  quotedReply?: Reply | null
}

interface Emits {
  (e: 'reply-success'): void
  (e: 'clear-quoted'): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emits>()

// 响应式数据
const replyFormRef = ref()
const submitting = ref(false)

const replyForm = reactive({
  ticket_id: props.ticketId,
  ticket_accept_status: 1,
  ticket_content: '',
  ticket_user_id: 0 // 将从当前用户状态获取
})

// 表单验证规则
const replyRules = {
  ticket_accept_status: [
    { required: true, message: '请选择回复类型', trigger: 'change' }
  ],
  ticket_content: [
    { required: true, message: '请输入回复内容', trigger: 'blur' },
    { min: 5, message: '回复内容至少需要5个字符', trigger: 'blur' },
    { max: 1000, message: '回复内容不能超过1000个字符', trigger: 'blur' }
  ]
}

// 状态选项
const statusOptions = ref([
  { label: '用户回复', value: 1 },
  { label: '受理回复', value: 2 },
  { label: '处理回复', value: 3 },
  { label: '关闭回复', value: 4 }
])

// 快速回复模板
const quickReplyTemplates = ref<QuickReplyTemplate[]>([
  { id: 1, title: '收到', content: '您好，我们已收到您的反馈，会尽快处理。' },
  { id: 2, title: '处理中', content: '您的问题我们正在处理中，请耐心等待。' },
  { id: 3, title: '需要更多信息', content: '为了更好地帮助您，请提供更多详细信息。' },
  { id: 4, title: '已解决', content: '您的问题已解决，如有其他疑问请随时联系我们。' },
  { id: 5, title: '感谢反馈', content: '感谢您的反馈，我们会持续改进服务质量。' }
])

// 计算属性
const currentAcceptStatus = computed(() => replyForm.ticket_accept_status)

// 监听引用回复变化
watch(() => props.quotedReply, (newVal) => {
  if (newVal) {
    const quotedText = `@${getUserDisplayName(newVal.ticket_user_id)} `
    replyForm.ticket_content = quotedText + replyForm.ticket_content
  }
}, { immediate: true })

// 方法
const getUserDisplayName = (userId: number): string => {
  // TODO: 从用户状态获取用户名
  return `用户${userId}`
}

const getAcceptStatusName = (status: number): string => {
  const option = statusOptions.value.find(opt => opt.value === status)
  return option?.label || '未知状态'
}

const getStatusTagType = (status: number): string => {
  const typeMap: Record<number, string> = {
    1: 'info',
    2: 'primary',
    3: 'warning',
    4: 'success'
  }
  return typeMap[status] || 'info'
}

const handleStatusChange = (status: number) => {
  // 根据不同状态给出不同的提示或默认内容
  switch (status) {
    case 2:
      // 受理回复 - 可以提供一些受理相关的快速模板
      break
    case 3:
      // 处理回复
      break
    case 4:
      // 关闭回复 - 提示这将关闭工单
      ElMessageBox.confirm(
        '选择"关闭回复"将会关闭此工单，确定继续吗？',
        '确认操作',
        {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }
      ).catch(() => {
        // 用户取消，恢复到上一个状态
        replyForm.ticket_accept_status = 1
      })
      break
  }
}

const insertTemplate = (content: string) => {
  if (replyForm.ticket_content) {
    replyForm.ticket_content += '\n\n' + content
  } else {
    replyForm.ticket_content = content
  }
}

const clearQuotedReply = () => {
  emit('clear-quoted')
}

const submitReply = async () => {
  try {
    await replyFormRef.value?.validate()
    
    submitting.value = true
    
    // TODO: 从用户状态获取当前用户ID
    replyForm.ticket_user_id = 1 // 临时设置
    
    const response = await http.post(`tickets/tickets/${props.ticketId}/replies`, replyForm)
    
    ElMessage.success('回复提交成功')
    resetForm()
    emit('reply-success')
    
  } catch (error) {
    console.error('提交回复失败:', error)
    ElMessage.error('提交回复失败')
  } finally {
    submitting.value = false
  }
}

const resetForm = () => {
  replyFormRef.value?.resetFields()
  replyForm.ticket_content = ''
  replyForm.ticket_accept_status = 1
}
</script>

<style scoped>
.reply-form-card {
  height: fit-content;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.quoted-reply {
  margin-bottom: 16px;
  padding: 12px;
  background-color: var(--el-fill-color-light);
  border-left: 3px solid var(--el-color-primary);
  border-radius: 4px;
}

.quoted-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 12px;
  font-weight: 500;
  color: var(--el-color-primary);
  margin-bottom: 8px;
}

.quoted-content {
  font-size: 13px;
  color: var(--el-text-color-regular);
  line-height: 1.4;
  font-style: italic;
}

.quick-reply-templates {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.quick-reply-templates .el-button {
  padding: 4px 8px;
  border: 1px dashed var(--el-border-color);
  border-radius: 4px;
  color: var(--el-text-color-regular);
  font-size: 12px;
}

.quick-reply-templates .el-button:hover {
  border-color: var(--el-color-primary);
  color: var(--el-color-primary);
  background-color: var(--el-color-primary-light-9);
}

.form-actions {
  display: flex;
  gap: 12px;
}

/* 确保表单在卡片中的合适间距 */
.el-form-item {
  margin-bottom: 18px;
}

.el-form-item:last-child {
  margin-bottom: 0;
}

/* 文本框样式调整 */
.el-textarea :deep(.el-textarea__inner) {
  resize: vertical;
  min-height: 120px;
}
</style>