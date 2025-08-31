<template>
  <el-card class="reply-list-card">
    <template #header>
      <div class="card-header">
        <span>工单回复 ({{ replies.length }})</span>
        <el-button 
          size="small" 
          @click="$emit('refresh')"
          :loading="loading"
        >
          <el-icon><Refresh /></el-icon>
          刷新
        </el-button>
      </div>
    </template>

    <div v-loading="loading" class="replies-container">
      <div v-if="replies.length === 0 && !loading" class="empty-replies">
        <el-empty description="暂无回复" :image-size="100">
          <template #description>
            <p class="empty-text">还没有人回复这个工单</p>
          </template>
        </el-empty>
      </div>

      <div v-else class="replies-list">
        <div 
          v-for="(reply, index) in replies" 
          :key="reply.id"
          class="reply-item"
          :class="{ 'reply-item-admin': isAdminReply(reply) }"
        >
          <!-- 回复头部 -->
          <div class="reply-header">
            <div class="user-info">
              <el-avatar :size="32" class="user-avatar">
                {{ getUserDisplayName(reply.ticket_user_id).charAt(0) }}
              </el-avatar>
              <div class="user-details">
                <span class="user-name">{{ getUserDisplayName(reply.ticket_user_id) }}</span>
                <span class="reply-time">{{ formatDateTime(reply.created_at) }}</span>
              </div>
            </div>
            <div class="reply-status">
              <el-tag 
                :type="getStatusTagType(reply.ticket_accept_status)" 
                size="small"
              >
                {{ getAcceptStatusName(reply.ticket_accept_status) }}
              </el-tag>
            </div>
          </div>

          <!-- 回复内容 -->
          <div class="reply-content">
            <div class="content-text" v-html="formatReplyContent(reply.ticket_content)"></div>
          </div>

          <!-- 回复底部 -->
          <div class="reply-footer">
            <div class="reply-actions">
              <el-button 
                type="text" 
                size="small" 
                @click="handleQuoteReply(reply)"
                v-if="canQuoteReply"
              >
                <el-icon><ChatDotRound /></el-icon>
                引用回复
              </el-button>
            </div>
            <div class="reply-index">
              #{{ index + 1 }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </el-card>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { Refresh, ChatDotRound } from '@element-plus/icons-vue'

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

interface Props {
  ticketId: number | string
  replies: Reply[]
  loading?: boolean
  canQuoteReply?: boolean
}

interface Emits {
  (e: 'refresh'): void
  (e: 'quote-reply', reply: Reply): void
}

const props = withDefaults(defineProps<Props>(), {
  loading: false,
  canQuoteReply: true
})

const emit = defineEmits<Emits>()

// 计算属性
const sortedReplies = computed(() => {
  return [...props.replies].sort((a, b) => {
    const timeA = typeof a.created_at === 'string' ? new Date(a.created_at).getTime() : a.created_at * 1000
    const timeB = typeof b.created_at === 'string' ? new Date(b.created_at).getTime() : b.created_at * 1000
    return timeA - timeB
  })
})

// 方法
const getUserDisplayName = (userId: number): string => {
  const reply = props.replies.find(r => r.ticket_user_id === userId)
  if (reply?.user?.username) {
    return reply.user.username
  }
  return `用户${userId}`
}

const isAdminReply = (reply: Reply): boolean => {
  // 通过受理状态判断是否为管理员回复
  // 1: 用户回复, 2: 受理回复, 3: 处理回复, 4: 关闭回复
  return [2, 3, 4].includes(reply.ticket_accept_status)
}

const getAcceptStatusName = (status: number): string => {
  const statusMap: Record<number, string> = {
    1: '用户回复',
    2: '受理回复', 
    3: '处理回复',
    4: '关闭回复'
  }
  return statusMap[status] || '未知状态'
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

const formatDateTime = (timestamp: number | string): string => {
  if (!timestamp) return '-'
  
  const date = typeof timestamp === 'string' ? new Date(timestamp) : new Date(timestamp * 1000)
  const now = new Date()
  const diff = now.getTime() - date.getTime()
  
  // 如果是今天
  if (diff < 24 * 60 * 60 * 1000 && date.getDate() === now.getDate()) {
    return date.toLocaleTimeString('zh-CN', { hour: '2-digit', minute: '2-digit' })
  }
  
  // 如果是昨天
  const yesterday = new Date(now.getTime() - 24 * 60 * 60 * 1000)
  if (date.getDate() === yesterday.getDate()) {
    return '昨天 ' + date.toLocaleTimeString('zh-CN', { hour: '2-digit', minute: '2-digit' })
  }
  
  // 其他时间
  return date.toLocaleString('zh-CN', { 
    month: '2-digit', 
    day: '2-digit', 
    hour: '2-digit', 
    minute: '2-digit' 
  })
}

const formatReplyContent = (content: string): string => {
  if (!content) return ''
  
  // 简单的换行处理
  return content.replace(/\n/g, '<br>')
}

const handleQuoteReply = (reply: Reply) => {
  emit('quote-reply', reply)
}
</script>

<style scoped>
.reply-list-card {
  height: fit-content;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.replies-container {
  max-height: 60vh;
  overflow-y: auto;
}

.empty-replies {
  padding: 20px 0;
}

.empty-text {
  color: var(--el-text-color-placeholder);
  margin: 0;
}

.replies-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.reply-item {
  border: 1px solid var(--el-border-color-light);
  border-radius: 8px;
  padding: 16px;
  background-color: var(--el-bg-color);
  transition: all 0.3s ease;
}

.reply-item:hover {
  border-color: var(--el-color-primary-light-5);
  box-shadow: 0 2px 8px var(--el-color-primary-light-9);
}

.reply-item-admin {
  background-color: var(--el-color-primary-light-9);
  border-color: var(--el-color-primary-light-7);
}

.reply-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  background-color: var(--el-color-primary);
  color: white;
  font-weight: bold;
}

.user-details {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.user-name {
  font-weight: 500;
  color: var(--el-text-color-primary);
  font-size: 14px;
}

.reply-time {
  font-size: 12px;
  color: var(--el-text-color-placeholder);
}

.reply-content {
  margin: 12px 0;
}

.content-text {
  line-height: 1.6;
  color: var(--el-text-color-regular);
  font-size: 14px;
  word-break: break-word;
}

.reply-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 12px;
  padding-top: 12px;
  border-top: 1px solid var(--el-border-color-lighter);
}

.reply-actions {
  display: flex;
  gap: 8px;
}

.reply-index {
  font-size: 12px;
  color: var(--el-text-color-placeholder);
  font-weight: 500;
}

/* 滚动条样式 */
.replies-container::-webkit-scrollbar {
  width: 6px;
}

.replies-container::-webkit-scrollbar-track {
  background: var(--el-fill-color-lighter);
  border-radius: 3px;
}

.replies-container::-webkit-scrollbar-thumb {
  background: var(--el-fill-color);
  border-radius: 3px;
}

.replies-container::-webkit-scrollbar-thumb:hover {
  background: var(--el-fill-color-dark);
}
</style>