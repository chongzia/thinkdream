<template>
  <div class="template-management">
    <div class="main-content">
      <el-row :gutter="12" class="content-row">
        <!-- 左侧：模板选择器 -->
        <el-col :xs="24" :sm="24" :md="10" :lg="8" :xl="6" class="template-section">
          <TemplateManagementSelector ref="templateListRef" />
        </el-col>
        <!-- 右侧：字段配置 -->
        <el-col :xs="24" :sm="24" :md="14" :lg="16" :xl="18" class="form-section">
          <el-container class="template-container">
            <el-card class="template-card">
              <!-- 头部区域 -->
              <template #header>
                <div class="template-header">
                  <div class="header-left">
                    <el-text size="large" tag="b">工单模板配置</el-text>
                    <el-tag v-if="selectedTemplate" type="info" size="small" class="template-name">
                      {{ selectedTemplate.ticket_name }}
                    </el-tag>
                  </div>
                  <el-space>
                    <el-button type="success" size="small" @click="handlePreview" :disabled="!canPreview">
                      <el-icon>
                        <View />
                      </el-icon>
                      预览模板
                    </el-button>
                    <el-button type="primary" size="small" @click="handleAddField" :disabled="!canAddField">
                      <el-icon>
                        <Plus />
                      </el-icon>
                      添加字段
                    </el-button>
                  </el-space>
                </div>
              </template>

              <!-- 内容区域 -->
              <div class="template-content">
                <!-- 空状态 -->
                <div v-if="!selectedTemplate" class="empty-state">
                  <el-empty description="请先选择一个模板进行配置" :image-size="120">
                    <el-text type="info" size="small">从左侧选择一个模板开始配置字段</el-text>
                  </el-empty>
                </div>

                <!-- 字段配置表格 -->
                <TemplateFieldsTable v-else :fields="fields" :loading="loading" @edit="handleEditField"
                  @delete="handleDeleteField" @move-up="handleMoveUp" @move-down="handleMoveDown" />
              </div>
            </el-card>

            <!-- 字段编辑抽屉 -->
            <el-drawer v-model="fieldDialogVisible" :title="isEditField ? '编辑模板字段' : '添加模板字段'" direction="rtl"
              size="800px" :close-on-click-modal="false" :close-on-press-escape="false">
              <TemplateFieldsEditForm v-if="fieldDialogVisible" :field="currentEditingField" :all-fields="fields"
                :selected-template="selectedTemplate" @save="handleSaveField" @cancel="fieldDialogVisible = false"
                @refresh="handleRefreshFields" />
            </el-drawer>

            <!-- 模板预览抽屉 -->
            <el-drawer v-model="previewVisible" direction="rtl" size="1000px" :close-on-click-modal="true"
              :close-on-press-escape="true" :show-close="true">
              <template #header>
                <div class="drawer-header">
                  <span class="drawer-title">模板预览</span>
                  <el-button type="primary" size="small" @click="previewVisible = false">
                    <el-icon>
                      <Close />
                    </el-icon>
                    关闭预览
                  </el-button>
                </div>
              </template>

              <TicketDynamicForm v-if="previewVisible && previewTemplateData" :template-data="previewTemplateData"
                @submit="handlePreviewSubmit" submit-text="预览提交" :display-header="true" :display-meta="true" />
            </el-drawer>
          </el-container>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, provide, computed, watch } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import { Plus, View, Close } from '@element-plus/icons-vue'
import http from '@/support/http'

import { useUserStore } from '@/stores/modules/user'
// 基础模板数据接口
interface TemplateData {
  id: number
  ticket_name: string
  ticket_description: string
  ticket_form?: string | JSON
  ticket_accept: number
  ticket_process: string
  ticket_accept_days: number
  ticket_process_days: number
  ticket_is_active: number
  created_at: number
  updated_at: number
}

// 字段配置接口
interface FieldConfig {
  name: string
  label: string
  type: FieldType
  placeholder: string
  required: boolean
  options: string
  show_option?: string
}

// 字段类型枚举
type FieldType =
  | 'text'
  | 'textarea'
  | 'number'
  | 'date'
  | 'select'
  | 'radio'
  | 'checkbox'
  | 'switch'
  | 'department'
  | 'position'

// 导入组件
import TemplateManagementSelector from './components/TemplateManagementSelector.vue'
import TemplateFieldsTable from './components/TemplateFieldsTable.vue'
import TemplateFieldsEditForm from './components/TemplateFieldsEditForm.vue'
import TicketDynamicForm from '@/components/ticket/TicketDynamicForm.vue'

// 权限检查
const userStore = useUserStore()

// 权限计算属性
const hasTemplateUpdatePermission = computed(() => {
  const actions = userStore.getActions
  const targetPermission = 'tickets.tickettemplates.update'
  return Array.isArray(actions) && actions.includes(targetPermission)
})

const hasTemplateStorePermission = computed(() => {
  const actions = userStore.getActions
  const targetPermission = 'tickets.tickettemplates.store'
  return Array.isArray(actions) && actions.includes(targetPermission)
})

const hasTemplateDestroyPermission = computed(() => {
  const actions = userStore.getActions
  const targetPermission = 'tickets.tickettemplates.destroy'
  return Array.isArray(actions) && actions.includes(targetPermission)
})

// 响应式数据
const selectedTemplate = ref<TemplateData | null>(null)
const templateListRef = ref()
const loading = ref(false)
const fields = ref<FieldConfig[]>([])
const fieldDialogVisible = ref(false)
const currentEditingField = ref<FieldConfig | null>(null)
const isEditField = ref(false)
const previewVisible = ref(false)
const previewTemplateData = ref<any>(null)

const canPreview = computed(() => {
  return selectedTemplate.value && fields.value.length > 0
})

const canAddField = computed(() => {
  return selectedTemplate.value !== null && hasTemplateUpdatePermission.value
})

// 处理模板选择
const handleTemplateSelect = (template: TemplateData | null) => {
  selectedTemplate.value = template
  // 如果模板为空，清空字段配置
  if (!template) {
    fields.value = []
  }
}

// 处理刷新事件
const handleRefresh = () => {
  // 触发模板列表刷新
  if (templateListRef.value?.refreshList) {
    templateListRef.value.refreshList()
  }
}

// 添加字段
const handleAddField = () => {
  if (!selectedTemplate?.value) {
    ElMessage.warning('请先选择模板')
    return
  }

  isEditField.value = false
  currentEditingField.value = null
  fieldDialogVisible.value = true
}

// 编辑字段
const handleEditField = (field: FieldConfig) => {
  isEditField.value = true
  currentEditingField.value = { ...field }
  fieldDialogVisible.value = true
}

// 保存字段
const handleSaveField = (fieldData: FieldConfig) => {
  if (isEditField.value && currentEditingField.value) {
    // 编辑模式：更新现有字段
    const index = fields.value.findIndex(f => f.name === currentEditingField.value?.name)
    if (index !== -1) {
      fields.value[index] = fieldData
    }
  } else {
    // 添加模式：添加新字段
    const fieldName = fieldData.name || `field_${fields.value.length + 1}`
    fields.value.push({
      ...fieldData,
      name: fieldName
    })
  }

  fieldDialogVisible.value = false
  ElMessage.success(isEditField.value ? '字段更新成功' : '字段添加成功')
}

// 刷新字段列表
const handleRefreshFields = () => {
  // 重新加载模板数据
  if (selectedTemplate?.value?.ticket_form) {
    const schema = typeof selectedTemplate.value.ticket_form === 'string'
      ? selectedTemplate.value.ticket_form
      : JSON.stringify(selectedTemplate.value.ticket_form, null, 2)
    fields.value = parseFieldsFromSchema(schema)
  }
}

// 创建预览模板数据，确保类型匹配 TicketDynamicForm 的 TemplateInfo 接口
const createPreviewTemplateData = (template: TemplateData, fields: FieldConfig[]) => {
  return {
    id: template.id,
    ticket_name: template.ticket_name,
    ticket_description: template.ticket_description || '',
    ticket_form: JSON.stringify(fields),
    ticket_accept_days: template.ticket_accept_days,
    ticket_process_days: template.ticket_process_days,
    ticket_accept: template.ticket_accept,
    ticket_process: template.ticket_process
  }
}

// 预览模板
const handlePreview = () => {
  if (!selectedTemplate?.value) {
    ElMessage.warning('请先选择模板')
    return
  }

  if (fields.value.length === 0) {
    ElMessage.warning('请先添加字段再预览')
    return
  }

  previewTemplateData.value = createPreviewTemplateData(selectedTemplate.value, fields.value)
  previewVisible.value = true
}

// 预览提交
const handlePreviewSubmit = (formData: any) => {
  console.log('预览提交的数据:', formData)
  ElMessage.success('预览提交成功')
  previewVisible.value = false
}

// 删除字段
const handleDeleteField = async (field: FieldConfig, index: number) => {
  try {
    await ElMessageBox.confirm(
      `确定要删除字段 "${field.label}" 吗？`,
      '确认删除',
      {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }
    )

    // 从本地数组中删除
    fields.value.splice(index, 1)

    // 更新数据库
    await updateTemplateForm()

    ElMessage.success('字段删除成功')
  } catch (error) {
    if (error !== 'cancel') {
      console.error('删除字段失败:', error)
      ElMessage.error('删除字段失败')
    }
  }
}

// 更新模板表单到数据库
const updateTemplateForm = async () => {
  if (!selectedTemplate.value?.id) {
    throw new Error('请先选择模板')
  }

  try {
    // 生成JSON Schema
    const schema = JSON.stringify(fields.value, null, 2)

    // 保存到数据库
    const response = await http.put(`tickets/ticket/templates/${selectedTemplate.value.id}/form-config`, {
      ticket_form: schema
    })

    if (response.data.code !== 200) {
      throw new Error(response.data.message || '保存失败')
    }
  } catch (error: any) {
    console.error('更新模板表单失败:', error)
    throw error
  }
}

// 移动字段
const moveField = async (fromIndex: number, toIndex: number, message: string) => {
  if (fromIndex >= 0 && toIndex >= 0 && fromIndex < fields.value.length && toIndex < fields.value.length) {
    const temp = fields.value[fromIndex]
    fields.value[fromIndex] = fields.value[toIndex]
    fields.value[toIndex] = temp

    // 更新数据库
    await updateTemplateForm()

    ElMessage.success(message)
  }
}

// 上移字段
const handleMoveUp = async (index: number) => {
  if (index > 0) {
    try {
      await moveField(index, index - 1, '字段上移成功')
    } catch (error) {
      console.error('字段上移失败:', error)
      ElMessage.error('字段上移失败')
    }
  }
}

// 下移字段
const handleMoveDown = async (index: number) => {
  if (index < fields.value.length - 1) {
    try {
      await moveField(index, index + 1, '字段下移成功')
    } catch (error) {
      console.error('字段下移失败:', error)
      ElMessage.error('字段下移失败')
    }
  }
}

// 监听模板变化
watch(() => selectedTemplate?.value, (template) => {
  if (template?.ticket_form) {
    const schema = typeof template.ticket_form === 'string'
      ? template.ticket_form
      : JSON.stringify(template.ticket_form, null, 2)
    fields.value = parseFieldsFromSchema(schema)
  } else {
    fields.value = []
  }
}, { immediate: true })

// JSON 解析工具函数
const parseFieldsFromSchema = (jsonString: string): FieldConfig[] => {
  if (!jsonString.trim()) return []

  try {
    const parsed = JSON.parse(jsonString)
    if (!Array.isArray(parsed)) return []

    return parsed.map((field, index) => ({
      name: field.name || `field_${index + 1}`,
      label: field.label || `字段${index + 1}`,
      type: field.type || 'text',
      placeholder: field.placeholder || '',
      required: !!field.required,
      options: Array.isArray(field.options) ? field.options.join(',') : (field.options || ''),
      show_option: field.show_option || ''
    }))
  } catch (error) {
    console.error('解析JSON失败:', error)
    return []
  }
}

// 向子组件提供数据和方法
provide('selectedTemplate', selectedTemplate)
provide('onTemplateSelect', handleTemplateSelect as (template: TemplateData | null) => void)
</script>

<style scoped>
.template-management {
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

/* 模板相关样式 */
.template-container {
  width: 100%;
  height: 100%;
}

.template-card {
  width: 100%;
  height: 100%;
}

.template-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.template-name {
  margin-left: 8px;
}

.template-content {
  height: calc(100% - 80px);
  overflow-y: auto;
}

.empty-state {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  min-height: 300px;
}

.drawer-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.drawer-title {
  font-size: 16px;
  font-weight: 600;
  color: var(--el-text-color-primary);
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
  .template-management {
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