<template>
  <div class="template-viewer">
    <el-card class="viewer-card" shadow="never">
      <template #header>
        <div class="card-header">
          <div class="header-left">
            <el-icon size="20" class="header-icon">
              <Document />
            </el-icon>
            <h3 class="card-title">模板详情</h3>
          </div>
          <div class="header-actions">
            <el-button size="small" @click="$emit('close')">
              <el-icon><Close /></el-icon>
              关闭
            </el-button>
          </div>
        </div>
      </template>

      <div v-loading="loading" class="viewer-content">
        <template v-if="templateData">
          <!-- 基础信息 -->
          <el-card class="info-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <Document />
                </el-icon>
                <el-text tag="b">基础信息</el-text>
              </div>
            </template>
            <el-descriptions :column="2" border>
              <el-descriptions-item label="模板名称">
                {{ templateData.ticket_name }}
              </el-descriptions-item>
              <el-descriptions-item label="模板状态">
                <el-tag :type="templateData.ticket_is_active === 1 ? 'success' : 'warning'">
                  {{ templateData.ticket_is_active === 1 ? '已启用' : '已禁用' }}
                </el-tag>
              </el-descriptions-item>
              <el-descriptions-item label="模板描述" :span="2">
                {{ templateData.ticket_description || '暂无描述' }}
              </el-descriptions-item>
            </el-descriptions>
          </el-card>

          <!-- 人员配置 -->
          <el-card class="info-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <UserFilled />
                </el-icon>
                <el-text tag="b">人员配置</el-text>
              </div>
            </template>
            <el-descriptions :column="2" border>
              <el-descriptions-item label="受理人">
                <el-tag type="primary">{{ getAcceptorName(templateData.ticket_accept) }}</el-tag>
              </el-descriptions-item>
              <el-descriptions-item label="流程处理人">
                <div class="process-people">
                  <el-tag 
                    v-for="(person, index) in getProcessPeople(templateData.ticket_process)" 
                    :key="index" 
                    size="small"
                    type="info"
                    class="mr-1"
                  >
                    {{ person }}
                  </el-tag>
                </div>
              </el-descriptions-item>
            </el-descriptions>
          </el-card>

          <!-- 时间配置 -->
          <el-card class="info-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <Clock />
                </el-icon>
                <el-text tag="b">时间配置</el-text>
              </div>
            </template>
            <el-descriptions :column="2" border>
              <el-descriptions-item label="受理时限">
                <el-tag type="warning">{{ templateData.ticket_accept_days }} 天</el-tag>
              </el-descriptions-item>
              <el-descriptions-item label="处理时限">
                <el-tag type="danger">{{ templateData.ticket_process_days }} 天</el-tag>
              </el-descriptions-item>
            </el-descriptions>
          </el-card>

          <!-- 表单字段配置 -->
          <el-card v-if="formFields.length > 0" class="info-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <List />
                </el-icon>
                <el-text tag="b">表单字段配置</el-text>
              </div>
            </template>
            <el-table :data="formFields" border stripe>
              <el-table-column prop="label" label="字段名称" width="150" />
              <el-table-column prop="type" label="字段类型" width="120">
                <template #default="{ row }">
                  <el-tag :type="getFieldTypeColor(row.type)" size="small">
                    {{ getFieldTypeName(row.type) }}
                  </el-tag>
                </template>
              </el-table-column>
              <el-table-column prop="required" label="是否必填" width="100">
                <template #default="{ row }">
                  <el-tag :type="row.required ? 'danger' : 'info'" size="small">
                    {{ row.required ? '必填' : '可选' }}
                  </el-tag>
                </template>
              </el-table-column>
              <el-table-column prop="placeholder" label="占位符" />
              <el-table-column prop="options" label="选项" width="200">
                <template #default="{ row }">
                  <span v-if="row.options">{{ row.options }}</span>
                  <span v-else class="text-muted">-</span>
                </template>
              </el-table-column>
            </el-table>
          </el-card>

          <!-- 时间信息 -->
          <el-card class="info-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <Calendar />
                </el-icon>
                <el-text tag="b">时间信息</el-text>
              </div>
            </template>
            <el-descriptions :column="2" border>
              <el-descriptions-item label="创建时间">
                {{ formatTime(templateData.created_at) }}
              </el-descriptions-item>
              <el-descriptions-item label="更新时间">
                {{ formatTime(templateData.updated_at) }}
              </el-descriptions-item>
            </el-descriptions>
          </el-card>
        </template>

        <el-empty v-else-if="!loading" description="模板数据加载失败" />
      </div>
    </el-card>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import { ElMessage } from 'element-plus'
import {
  Document,
  UserFilled,
  Clock,
  List,
  Calendar,
  Close
} from '@element-plus/icons-vue'
import http from '@/support/http'

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
  created_at: number
  updated_at: number
}

interface FormField {
  label: string
  type: string
  required: boolean
  placeholder?: string
  options?: string
}

// Props
interface Props {
  templateId: number
}

const props = defineProps<Props>()

// Emits
const emit = defineEmits<{
  close: []
}>()

// 响应式数据
const loading = ref(false)
const templateData = ref<TemplateData | null>(null)
const formFields = ref<FormField[]>([])

// 用户映射
const userMap = new Map([
  [1, '系统管理员'],
  [2, '技术支持'],
  [3, '客服人员']
])

// 方法
const fetchTemplateData = async () => {
  if (!props.templateId) return
  
  loading.value = true
  try {
    const response = await http.get(`tickets/ticket/templates/${props.templateId}`)
    if (response.data && response.data.code === 200) {
      templateData.value = response.data.data
      parseFormFields()
    } else {
      ElMessage.error('获取模板数据失败')
    }
  } catch (error) {
    console.error('获取模板数据失败:', error)
    ElMessage.error('获取模板数据失败')
  } finally {
    loading.value = false
  }
}

const parseFormFields = () => {
  if (!templateData.value?.ticket_form) {
    formFields.value = []
    return
  }

  try {
    const formData = typeof templateData.value.ticket_form === 'string' 
      ? JSON.parse(templateData.value.ticket_form) 
      : templateData.value.ticket_form
    
    formFields.value = Array.isArray(formData) ? formData : []
  } catch (error) {
    console.error('解析表单字段失败:', error)
    formFields.value = []
  }
}

const getAcceptorName = (acceptorId: number): string => {
  return userMap.get(acceptorId) || `用户${acceptorId}`
}

const getProcessPeople = (processString: string): string[] => {
  if (!processString) return []
  
  try {
    const processIds = processString.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id))
    return processIds.map(id => userMap.get(id) || `用户${id}`)
  } catch (error) {
    return []
  }
}

const getFieldTypeName = (type: string): string => {
  const typeMap: Record<string, string> = {
    'text': '文本',
    'textarea': '多行文本',
    'number': '数字',
    'select': '下拉选择',
    'radio': '单选',
    'checkbox': '多选',
    'date': '日期',
    'datetime': '日期时间',
    'file': '文件上传'
  }
  return typeMap[type] || type
}

const getFieldTypeColor = (type: string): string => {
  const colorMap: Record<string, string> = {
    'text': 'primary',
    'textarea': 'success',
    'number': 'warning',
    'select': 'info',
    'radio': 'danger',
    'checkbox': 'danger',
    'date': 'success',
    'datetime': 'success',
    'file': 'warning'
  }
  return colorMap[type] || 'info'
}

const formatTime = (timestamp: number): string => {
  if (!timestamp) return '-'
  const date = new Date(timestamp * 1000)
  return date.toLocaleString('zh-CN')
}

onMounted(() => {
  fetchTemplateData()
})
</script>

<style scoped>
.template-viewer {
  height: 100%;
  overflow-y: auto;
  padding: 0;
  background: linear-gradient(135deg, var(--el-fill-color-lighter) 0%, var(--el-fill-color-light) 100%);
}

.viewer-card {
  border-radius: 12px;
  border: none;
  box-shadow: 0 8px 32px var(--el-box-shadow-light);
  height: 100%;
  backdrop-filter: blur(10px);
  background: var(--el-bg-color);
}

.viewer-card :deep(.el-card__body) {
  padding: 0;
  height: 100%;
}

.viewer-card :deep(.el-card__header) {
  background: transparent;
  border-bottom: 1px solid var(--el-border-color-lighter);
  border-radius: 12px 12px 0 0;
  padding: 0;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.header-icon {
  color: var(--el-color-primary);
  font-size: 20px;
}

.card-title {
  margin: 0;
  font-size: 20px;
  font-weight: 600;
  color: var(--el-text-color-primary);
}

.header-actions {
  display: flex;
  gap: 12px;
}

.viewer-content {
  padding: 24px;
  height: calc(100% - 88px);
  overflow-y: auto;
}

.info-section {
  margin-bottom: 24px;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.info-section:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px var(--el-box-shadow-light);
}

.info-section:last-child {
  margin-bottom: 0;
}

.info-section :deep(.el-card__header) {
  background: linear-gradient(135deg, var(--el-fill-color-light) 0%, var(--el-fill-color-lighter) 100%);
  border-bottom: 1px solid var(--el-border-color-lighter);
  border-radius: 8px 8px 0 0;
  padding: 16px 20px;
  margin-bottom: 10px;
}

.info-section :deep(.el-card__body) {
  padding: 20px;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 10px;
}

.section-icon {
  color: var(--el-color-primary);
  font-size: 16px;
}

.process-people {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
}

.mr-1 {
  margin-right: 4px;
}

.text-muted {
  color: var(--el-text-color-placeholder);
}

/* 滚动条样式 */
.viewer-content::-webkit-scrollbar {
  width: 6px;
}

.viewer-content::-webkit-scrollbar-track {
  background: var(--el-fill-color-lighter);
  border-radius: 3px;
}

.viewer-content::-webkit-scrollbar-thumb {
  background: var(--el-color-primary-light-3);
  border-radius: 3px;
}

.viewer-content::-webkit-scrollbar-thumb:hover {
  background: var(--el-color-primary);
}

@media (max-width: 768px) {
  .card-header {
    flex-direction: column;
    gap: 16px;
    align-items: flex-start;
  }

  .header-actions {
    width: 100%;
    justify-content: flex-end;
  }

  .viewer-content {
    padding: 16px;
  }

  .info-section {
    margin-bottom: 16px;
  }
}
</style>
