<template>
  <div 
    class="ticket-template" 
    :class="[
      `ticket-template--${mode}`,
      { 
        'ticket-template--selectable': selectable,
        'ticket-template--selected': selected,
        'ticket-template--compact': compact,
        'ticket-template--loading': loading
      }
    ]"
    v-loading="loading"
  >
    <!-- 卡片模式 -->
    <el-card 
      v-if="mode === 'card'" 
      :class="cardClasses"
      @click="handleSelect"
      shadow="hover"
    >
      <template #header>
        <div class="card-header">
          <div class="template-title">
            <el-icon v-if="selectable && selected" class="selected-icon">
              <Check />
            </el-icon>
            <span class="template-name">{{ templateInfo.ticket_name }}</span>
            <el-tag 
              :type="templateInfo.ticket_is_active === 1 ? 'success' : 'danger'" 
              size="small"
            >
              {{ templateInfo.ticket_is_active === 1 ? '启用' : '禁用' }}
            </el-tag>
          </div>
          <div class="template-actions" v-if="showActions">
            <slot name="actions" :template="templateInfo">
              <el-button size="small" type="primary" @click.stop="handleViewDetail">
                <el-icon><View /></el-icon>
              </el-button>
              <el-button size="small" @click.stop="handleEdit">
                <el-icon><Edit /></el-icon>
              </el-button>
            </slot>
          </div>
        </div>
      </template>
      
      <div class="card-content">
        <p class="template-description">
          {{ templateInfo.ticket_description || '暂无描述' }}
        </p>
        <div class="template-meta">
          <div class="meta-item">
            <span class="meta-label">受理人ID:</span>
            <span class="meta-value">{{ templateInfo.ticket_accept }}</span>
          </div>
          <div class="meta-item">
            <span class="meta-label">流程人:</span>
            <span class="meta-value">{{ templateInfo.ticket_process }}</span>
          </div>
          <div class="meta-item">
            <span class="meta-label">受理天数:</span>
            <span class="meta-value">{{ templateInfo.ticket_accept_days }}天</span>
          </div>
          <div class="meta-item">
            <span class="meta-label">处理天数:</span>
            <span class="meta-value">{{ templateInfo.ticket_process_days }}天</span>
          </div>
        </div>
        <div class="form-info" v-if="parsedFormConfig.length > 0">
          <el-divider content-position="left">表单字段</el-divider>
          <div class="form-fields-preview">
            <el-tag 
              v-for="field in parsedFormConfig.slice(0, 5)" 
              :key="field.name"
              size="small"
              class="field-tag"
            >
              {{ field.label }}
            </el-tag>
            <span v-if="parsedFormConfig.length > 5" class="more-fields">
              等{{ parsedFormConfig.length }}个字段
            </span>
          </div>
        </div>
      </div>
    </el-card>

    <!-- 列表模式 -->
    <div v-else-if="mode === 'list'" class="list-content">
      <div class="list-main">
        <div class="template-name">{{ templateInfo.ticket_name }}</div>
        <div class="template-description">{{ templateInfo.ticket_description || '-' }}</div>
      </div>
      <div class="list-meta">
        <el-tag 
          :type="templateInfo.ticket_is_active === 1 ? 'success' : 'danger'" 
          size="small"
        >
          {{ templateInfo.ticket_is_active === 1 ? '启用' : '禁用' }}
        </el-tag>
        <span class="fields-count" v-if="parsedFormConfig.length > 0">
          {{ parsedFormConfig.length }}个字段
        </span>
      </div>
      <div class="list-actions" v-if="showActions">
        <slot name="actions" :template="templateInfo">
          <el-button size="small" type="primary" @click="handleViewDetail">查看</el-button>
        </slot>
      </div>
    </div>

    <!-- 详情模式 -->
    <div v-else-if="mode === 'detail'" class="detail-content">
      <el-card class="template-info">
        <template #header>
          <div class="card-header">
            <span>模板基本信息</span>
            <div class="header-actions" v-if="showActions">
              <slot name="actions" :template="templateInfo">
                <el-button size="small" @click="handleEdit">
                  <el-icon><Edit /></el-icon>
                  编辑
                </el-button>
                <el-button size="small" @click="handleCopy">
                  <el-icon><CopyDocument /></el-icon>
                  复制配置
                </el-button>
              </slot>
            </div>
          </div>
        </template>
        
        <el-descriptions :column="2" border>
          <el-descriptions-item label="模板ID">{{ templateInfo.id }}</el-descriptions-item>
          <el-descriptions-item label="模板名称">{{ templateInfo.ticket_name }}</el-descriptions-item>
          <el-descriptions-item label="模板描述">{{ templateInfo.ticket_description || '-' }}</el-descriptions-item>
          <el-descriptions-item label="状态">
            <el-tag :type="templateInfo.ticket_is_active === 1 ? 'success' : 'danger'">
              {{ templateInfo.ticket_is_active === 1 ? '启用' : '禁用' }}
            </el-tag>
          </el-descriptions-item>
          <el-descriptions-item label="受理人ID">{{ templateInfo.ticket_accept }}</el-descriptions-item>
          <el-descriptions-item label="流程人">{{ templateInfo.ticket_process }}</el-descriptions-item>
          <el-descriptions-item label="受理天数">{{ templateInfo.ticket_accept_days }}天</el-descriptions-item>
          <el-descriptions-item label="处理天数">{{ templateInfo.ticket_process_days }}天</el-descriptions-item>
          <el-descriptions-item label="创建时间" v-if="templateInfo.created_at">
            {{ formatDateTime(templateInfo.created_at) }}
          </el-descriptions-item>
          <el-descriptions-item label="更新时间" v-if="templateInfo.updated_at">
            {{ formatDateTime(templateInfo.updated_at) }}
          </el-descriptions-item>
        </el-descriptions>
      </el-card>

      <!-- 表单字段详情 -->
      <el-card class="template-form mt-4" v-if="parsedFormConfig.length > 0">
        <template #header>
          <div class="card-header">
            <span>表单字段 ({{ parsedFormConfig.length }}个)</span>
          </div>
        </template>
        
        <el-table :data="parsedFormConfig" border stripe>
          <el-table-column prop="label" label="字段标签" width="150" />
          <el-table-column prop="name" label="字段名称" width="150" />
          <el-table-column prop="type" label="字段类型" width="120">
            <template #default="scope">
              <el-tag :type="getFieldTypeTag(scope.row.type)" size="small">
                {{ getFieldTypeName(scope.row.type) }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column prop="required" label="是否必填" width="100">
            <template #default="scope">
              <el-tag :type="scope.row.required ? 'danger' : 'info'" size="small">
                {{ scope.row.required ? '必填' : '选填' }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column prop="placeholder" label="提示信息" show-overflow-tooltip />
          <el-table-column prop="options" label="选项配置" show-overflow-tooltip />
        </el-table>
      </el-card>
    </div>

    <!-- 简单模式 -->
    <div v-else-if="mode === 'simple'" class="simple-content">
      <div class="simple-main">
        <span class="template-name">{{ templateInfo.ticket_name }}</span>
        <el-tag 
          :type="templateInfo.ticket_is_active === 1 ? 'success' : 'danger'" 
          size="small"
        >
          {{ templateInfo.ticket_is_active === 1 ? '启用' : '禁用' }}
        </el-tag>
      </div>
      <div class="simple-meta" v-if="!compact">
        <span class="meta-text">{{ templateInfo.ticket_description || '暂无描述' }}</span>
        <span class="fields-count" v-if="parsedFormConfig.length > 0">
          | {{ parsedFormConfig.length }}个字段
        </span>
      </div>
    </div>

    <!-- 额外内容插槽 -->
    <div class="template-extra" v-if="$slots.extra">
      <slot name="extra" :template="templateInfo" />
    </div>

    <!-- 空状态 -->
    <el-empty v-if="!templateInfo.id && !loading" description="暂无模板数据" />
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted, watch } from 'vue'
import { Check, View, Edit, CopyDocument } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'
import http from '@/support/http'

// 模板数据接口
interface TemplateData {
  id?: number
  ticket_name?: string
  ticket_description?: string
  ticket_form?: string
  ticket_accept?: number
  ticket_process?: string
  ticket_accept_days?: number
  ticket_process_days?: number
  ticket_is_active?: number
  created_at?: string
  updated_at?: string
}

// Props接口
interface Props {
  mode?: 'card' | 'list' | 'detail' | 'simple'
  templateData?: TemplateData
  templateId?: number
  selectable?: boolean
  selected?: boolean
  showActions?: boolean
  compact?: boolean
  loading?: boolean
}

// Events接口
interface Emits {
  select: [template: TemplateData]
  'view-detail': [template: TemplateData]
  edit: [template: TemplateData]
  copy: [config: string]
}

const props = withDefaults(defineProps<Props>(), {
  mode: 'card',
  selectable: false,
  selected: false,
  showActions: true,
  compact: false,
  loading: false
})

const emit = defineEmits<Emits>()

// 内部状态
const internalLoading = ref(false)
const internalTemplateData = ref<TemplateData>({})

// 计算属性
const loading = computed(() => props.loading || internalLoading.value)

const templateInfo = computed(() => {
  return props.templateData || internalTemplateData.value
})

const cardClasses = computed(() => ({
  'selectable-card': props.selectable,
  'selected-card': props.selected,
  'cursor-pointer': props.selectable
}))

// 解析表单配置
const parsedFormConfig = computed(() => {
  if (!templateInfo.value.ticket_form) return []
  
  try {
    return typeof templateInfo.value.ticket_form === 'string' 
      ? JSON.parse(templateInfo.value.ticket_form)
      : templateInfo.value.ticket_form
  } catch (error) {
    console.error('解析表单配置失败:', error)
    return []
  }
})

// 获取模板数据
const fetchTemplateData = async (id: number) => {
  if (!id) return
  
  internalLoading.value = true
  try {
    const response = await http.get(`/tickets/ticket/templates/${id}`)
    if (response.data && response.data.data) {
      internalTemplateData.value = response.data.data
    }
  } catch (error) {
    console.error('获取模板数据失败:', error)
    ElMessage.error('获取模板数据失败')
  } finally {
    internalLoading.value = false
  }
}

// 字段类型相关方法
const getFieldTypeTag = (type: string): string => {
  const typeTagMap: Record<string, string> = {
    'text': 'primary',
    'textarea': 'primary',
    'number': 'success',
    'email': 'warning',
    'phone': 'warning',
    'select': 'info',
    'radio': 'info',
    'checkbox': 'danger',
    'date': 'success',
    'file': 'warning',
    'image': 'success',
    'department': 'warning',
    'position': 'warning'
  }
  return typeTagMap[type] || 'primary'
}

const getFieldTypeName = (type: string): string => {
  const typeNameMap: Record<string, string> = {
    'text': '文本',
    'textarea': '多行文本',
    'number': '数字',
    'email': '邮箱',
    'phone': '电话',
    'select': '下拉选择',
    'radio': '单选',
    'checkbox': '多选',
    'date': '日期',
    'file': '文件',
    'image': '图片',
    'department': '部门',
    'position': '职位'
  }
  return typeNameMap[type] || type
}

// 格式化日期时间
const formatDateTime = (dateTime: string): string => {
  if (!dateTime) return '-'
  return new Date(dateTime).toLocaleString('zh-CN')
}

// 事件处理方法
const handleSelect = () => {
  if (props.selectable && templateInfo.value.id) {
    emit('select', templateInfo.value)
  }
}

const handleViewDetail = () => {
  if (templateInfo.value.id) {
    emit('view-detail', templateInfo.value)
  }
}

const handleEdit = () => {
  if (templateInfo.value.id) {
    emit('edit', templateInfo.value)
  }
}

const handleCopy = async () => {
  if (!templateInfo.value.ticket_form) {
    ElMessage.warning('暂无表单配置可复制')
    return
  }
  
  try {
    const formattedConfig = JSON.stringify(parsedFormConfig.value, null, 2)
    await navigator.clipboard.writeText(formattedConfig)
    emit('copy', formattedConfig)
    ElMessage.success('已复制到剪贴板')
  } catch (error) {
    console.error('复制失败:', error)
    ElMessage.error('复制失败')
  }
}

// 监听templateId变化
watch(() => props.templateId, (newId) => {
  if (newId && !props.templateData) {
    fetchTemplateData(newId)
  }
}, { immediate: true })

// 组件挂载时处理
onMounted(() => {
  if (props.templateId && !props.templateData) {
    fetchTemplateData(props.templateId)
  }
})
</script>

<style scoped>
.ticket-template {
  width: 100%;
}

/* 卡片模式样式 */
.ticket-template--card .selectable-card {
  cursor: pointer;
  transition: all 0.3s ease;
}

.ticket-template--card .selectable-card:hover {
  border-color: var(--el-color-primary);
  box-shadow: 0 4px 12px rgba(64, 158, 255, 0.15);
}

.ticket-template--card .selected-card {
  border-color: var(--el-color-primary);
  background-color: var(--el-color-primary-light-9);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  width: 100%;
}

.template-title {
  display: flex;
  align-items: center;
  gap: 8px;
  flex: 1;
}

.template-name {
  font-weight: 600;
  color: var(--el-text-color-primary);
}

.selected-icon {
  color: var(--el-color-primary);
  font-size: 16px;
}

.template-actions {
  display: flex;
  gap: 4px;
}

.card-content {
  padding-top: 8px;
}

.template-description {
  color: var(--el-text-color-regular);
  margin-bottom: 16px;
  line-height: 1.5;
}

.template-meta {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-bottom: 16px;
}

.meta-item {
  display: flex;
  align-items: center;
  font-size: 12px;
}

.meta-label {
  color: var(--el-text-color-regular);
  margin-right: 4px;
}

.meta-value {
  color: var(--el-text-color-primary);
  font-weight: 500;
}

.form-fields-preview {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
  align-items: center;
}

.field-tag {
  margin: 0;
}

.more-fields {
  font-size: 12px;
  color: var(--el-text-color-placeholder);
}

/* 列表模式样式 */
.list-content {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 8px 0;
}

.list-main {
  flex: 1;
}

.list-main .template-name {
  font-weight: 500;
  color: var(--el-text-color-primary);
  margin-bottom: 4px;
}

.list-main .template-description {
  font-size: 12px;
  color: var(--el-text-color-regular);
}

.list-meta {
  display: flex;
  align-items: center;
  gap: 8px;
}

.fields-count {
  font-size: 12px;
  color: var(--el-text-color-placeholder);
}

.list-actions {
  display: flex;
  gap: 4px;
}

/* 详情模式样式 */
.detail-content {
  max-height: 70vh;
  overflow-y: auto;
}

.header-actions {
  display: flex;
  gap: 8px;
}

/* 简单模式样式 */
.simple-content {
  padding: 4px 0;
}

.simple-main {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 4px;
}

.simple-main .template-name {
  font-weight: 500;
  color: var(--el-text-color-primary);
}

.simple-meta {
  font-size: 12px;
  color: var(--el-text-color-regular);
}

.meta-text {
  margin-right: 8px;
}

/* 紧凑模式 */
.ticket-template--compact .card-content {
  padding-top: 4px;
}

.ticket-template--compact .template-meta {
  margin-bottom: 8px;
}

.ticket-template--compact .form-info {
  margin-top: 8px;
}

/* 额外内容 */
.template-extra {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--el-border-color-lighter);
}
</style>
