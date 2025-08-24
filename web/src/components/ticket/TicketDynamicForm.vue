<template>
  <div class="ticket-form" v-loading="loading">
    <!-- 模板信息头部 -->
    <div v-if="templateInfo && displayHeader" class="form-header">
      <div class="header-content">
        <h3 class="template-title">{{ templateInfo.ticket_name }}</h3>
        <p v-if="templateInfo.ticket_description" class="template-desc">
          {{ templateInfo.ticket_description }}
        </p>
        <div v-if="displayMeta" class="template-meta">
          <el-tag size="small">受理: {{ templateInfo.ticket_accept_days }}天</el-tag>
          <el-tag size="small" type="warning">处理: {{ templateInfo.ticket_process_days }}天</el-tag>
        </div>
      </div>
    </div>

    <!-- 表单内容区域 -->
    <div v-if="hasFields" class="form-content">
      <el-scrollbar class="form-scrollbar">
        <el-form
          ref="formRef"
          :model="formData"
          :rules="validationRules"
          label-width="auto"
          class="dynamic-form"
        >
      <!-- 优先级选择 -->
      <div v-if="displayPriority" class="priority-section">
        <el-form-item label="优先级" prop="priority" required>
          <el-select v-model="formData.priority" placeholder="请选择优先级">
            <el-option
              v-for="option in priorityOptions"
              :key="option.value"
              :label="option.label"
              :value="option.value"
            >
              <el-tag :type="getPriorityColor(option.value)" size="small">
                {{ option.label }}
              </el-tag>
            </el-option>
          </el-select>
        </el-form-item>
      </div>

      <!-- 动态字段 -->
      <div v-if="fields.length" class="dynamic-section">
        <template v-for="field in fields" :key="field.name">
          <el-form-item
            v-if="!isFieldHidden(field)"
            :label="field.label"
            :prop="`dynamic.${field.name}`"
            :required="field.required"
          >
            <!-- 文本输入 -->
            <el-input
              v-if="field.type === 'text'"
              v-model="formData.dynamic[field.name]"
              :placeholder="field.placeholder"
              :maxlength="field.maxlength"
              :show-word-limit="field.showWordLimit || (field.maxlength && field.maxlength > 50)"
              @change="onFieldChange(field, $event)"
            />

            <!-- 多行文本 -->
            <el-input
              v-else-if="field.type === 'textarea'"
              v-model="formData.dynamic[field.name]"
              type="textarea"
              :rows="field.rows || 3"
              :placeholder="field.placeholder"
              :maxlength="field.maxlength"
              :show-word-limit="field.showWordLimit || (field.maxlength && field.maxlength > 50)"
              @change="onFieldChange(field, $event)"
            />

            <!-- 数字输入 -->
            <el-input-number
              v-else-if="field.type === 'number'"
              v-model="formData.dynamic[field.name]"
              :min="field.min"
              :max="field.max"
              :step="field.step || 1"
              :precision="field.precision"
              :controls="field.controls !== false"
              style="width: 100%"
              @change="onFieldChange(field, $event)"
            />

            <!-- 日期选择 -->
            <el-date-picker
              v-else-if="field.type === 'date'"
              v-model="formData.dynamic[field.name]"
              type="date"
              :placeholder="field.placeholder"
              :format="field.valueFormat || 'YYYY-MM-DD'"
              :value-format="field.valueFormat || 'YYYY-MM-DD'"
              :shortcuts="field.showShortcuts ? getDateShortcuts() : undefined"
              style="width: 100%"
              @change="onFieldChange(field, $event)"
            />

            <!-- 下拉选择 -->
            <el-select
              v-else-if="field.type === 'select'"
              v-model="formData.dynamic[field.name]"
              :placeholder="field.placeholder"
              clearable
              style="width: 100%"
              @change="onFieldChange(field, $event)"
            >
              <el-option
                v-for="option in getFieldOptions(field)"
                :key="option.value"
                :label="option.label"
                :value="option.value"
              />
            </el-select>

            <!-- 单选框 -->
            <el-radio-group
              v-else-if="field.type === 'radio'"
              v-model="formData.dynamic[field.name]"
              @change="onFieldChange(field, $event)"
            >
              <el-radio
                v-for="option in getFieldOptions(field)"
                :key="option.value"
                :value="option.value"
              >
                {{ option.label }}
              </el-radio>
            </el-radio-group>

            <!-- 多选框 -->
            <el-checkbox-group
              v-else-if="field.type === 'checkbox'"
              v-model="formData.dynamic[field.name]"
              @change="onFieldChange(field, $event)"
            >
              <el-checkbox
                v-for="option in getFieldOptions(field)"
                :key="option.value"
                :value="option.value"
              >
                {{ option.label }}
              </el-checkbox>
            </el-checkbox-group>

            <!-- 开关 -->
            <el-switch
              v-else-if="field.type === 'switch'"
              v-model="formData.dynamic[field.name]"
              :active-text="field.activeText || '是'"
              :inactive-text="field.inactiveText || '否'"
              @change="onFieldChange(field, $event)"
            />

            <!-- 部门选择 -->
            <RemoteTreeSelect
              v-else-if="field.type === 'department'"
              v-model="formData.dynamic[field.name]"
              table="departments"
              value="id"
              label="department_name"
              pid="parent_id"
              :placeholder="field.placeholder"
              clearable
              @change="onFieldChange(field, $event)"
            />

            <!-- 职位选择 -->
            <RemoteSelect
              v-else-if="field.type === 'position'"
              v-model="formData.dynamic[field.name]"
              table="positions"
              value="id"
              label="job_name"
              :placeholder="field.placeholder"
              clearable
              @change="onFieldChange(field, $event)"
            />

            <!-- 默认文本输入 -->
            <el-input
              v-else
              v-model="formData.dynamic[field.name]"
              :placeholder="field.placeholder"
              @change="onFieldChange(field, $event)"
            />
          </el-form-item>
        </template>
      </div>
    </el-form>
      </el-scrollbar>
    </div>

    <!-- 操作按钮 -->
    <div v-if="hasFields && displayActions" class="form-actions">
      <div class="actions-content">
        <el-button type="info" size="small" v-if="displayReset" @click="resetForm">重置</el-button>
        <el-button 
          v-if="hasSubmitPermission" 
          type="primary" 
          size="small" 
          :loading="submitting" 
          @click="submitForm"
        >
          {{ submitText }}
        </el-button>
      </div>
    </div>

    <!-- 空状态 -->
    <div v-else-if="!loading" class="empty-content">
      <el-empty description="暂无表单配置" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'
import { useUserStore } from '@/stores/modules/user'
import { 
  ElMessage, 
  ElMessageBox 
} from 'element-plus'
import {
  User, 
  UserFilled, 
  Clock, 
  Document, 
  Edit, 
  Delete, 
  Plus, 
  Setting
} from '@element-plus/icons-vue'
import http from '@/support/http'
import RemoteSelect from '@/components/admin/remote/RemoteSelect.vue'
import RemoteTreeSelect from '@/components/admin/remote/RemoteTreeSelect.vue'

// 类型定义
interface FieldConfig {
  name: string
  label: string
  type: string
  placeholder?: string
  required?: boolean
  options?: string | string[]
  show_option?: string
  maxlength?: number
  min?: number
  max?: number
  precision?: number
  rows?: number
  activeText?: string
  inactiveText?: string
  // 新增配置选项
  showWordLimit?: boolean
  step?: number
  controls?: boolean
  valueFormat?: string
  showShortcuts?: boolean
}

interface TemplateInfo {
  id: number
  ticket_name: string
  ticket_description?: string
  ticket_form?: string
  ticket_accept_days: number
  ticket_process_days: number
  ticket_accept: number
  ticket_process: string
}

// 枚举定义
enum TicketPriority {
  MINOR = 1,
  MODERATE = 2,
  CRITICAL = 3,
  SPECIAL = 4
}

enum TicketStatus {
  PENDING = 1,
  PROCESSING = 2,
  COMPLETED = 3,
  CLOSED = 4
}

// 常量定义
const TICKET_PRIORITY_COLORS: Record<TicketPriority, string> = {
  [TicketPriority.MINOR]: 'info',
  [TicketPriority.MODERATE]: 'warning',
  [TicketPriority.CRITICAL]: 'danger',
  [TicketPriority.SPECIAL]: 'primary'
}

// Props
interface Props {
  templateData?: TemplateInfo | null
  displayHeader?: boolean
  displayMeta?: boolean
  displayPriority?: boolean
  displayActions?: boolean
  displayReset?: boolean
  submitText?: string
  readonly?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  displayHeader: true,
  displayMeta: true,
  displayPriority: true,
  displayActions: true,
  displayReset: true,
  displayCancel: false,
  submitText: '提交',
  readonly: false
})

// Events
const emit = defineEmits<{
  submit: [data: any]
  cancel: []
  reset: []
  fieldChange: [field: FieldConfig, value: any]
}>()

// 响应式数据
const loading = ref(false)
const submitting = ref(false)
const templateInfo = ref<TemplateInfo | null>(null)
const formRef = ref()
const priorityOptions = ref<{ label: string; value: number }[]>([])

// 表单数据
const formData = ref({
  priority: TicketPriority.MODERATE,
  dynamic: {} as Record<string, any>
})

// 权限检查
const userStore = useUserStore()
const hasSubmitPermission = computed(() => {
  if (props.readonly) return false
  
  const actions = userStore.getActions
  const targetPermission = 'tickets.ticketsapp.ticketsformsubmit'
  
  return Array.isArray(actions) && actions.includes(targetPermission)
})

// 强制刷新权限
const refreshPermissions = async () => {
  try {
    // 使用store的强制刷新方法
    const newActions = await userStore.forceRefreshPermissions()
    return newActions
  } catch (error) {
    throw error
  }
}

// 计算属性
const hasFields = computed(() => 
  props.displayPriority || fields.value.length > 0
)

const fields = computed<FieldConfig[]>(() => {
  const template = props.templateData || templateInfo.value
  if (!template?.ticket_form) return []

  try {
    const config = typeof template.ticket_form === 'string' 
      ? JSON.parse(template.ticket_form) 
      : template.ticket_form
    return Array.isArray(config) ? config : []
  } catch {
    return []
  }
})

const validationRules = computed(() => {
  const rules: any = {}
  
  if (props.displayPriority) {
    rules.priority = [{ required: true, message: '请选择优先级', trigger: 'change' }]
  }

  fields.value.forEach(field => {
    if (field.required) {
      const message = `请${['select', 'radio', 'checkbox'].includes(field.type) ? '选择' : '填写'}${field.label}`
      const rule: any = { required: true, message, trigger: field.type === 'checkbox' ? 'change' : 'blur' }
      
      if (field.type === 'checkbox') {
        rule.type = 'array'
        rule.min = 1
      }
      
      rules[`dynamic.${field.name}`] = [rule]
    }
  })

  return rules
})

const getPriorityColor = computed(() => (priority: number) => 
  TICKET_PRIORITY_COLORS[priority as TicketPriority] || 'info'
)

// 方法
const getFieldOptions = (field: FieldConfig) => {
  if (!field.options) return []
  
  const optionsList = Array.isArray(field.options) 
    ? field.options 
    : field.options.split(/[,\n]/).map(opt => opt.trim()).filter(Boolean)
  
  return optionsList.map(opt => ({ label: opt, value: opt }))
}

const getDateShortcuts = () => {
  return [
    {
      text: '今天',
      value: new Date()
    },
    {
      text: '昨天',
      value: () => {
        const date = new Date()
        date.setTime(date.getTime() - 3600 * 1000 * 24)
        return date
      }
    },
    {
      text: '一周前',
      value: () => {
        const date = new Date()
        date.setTime(date.getTime() - 3600 * 1000 * 24 * 7)
        return date
      }
    },
    {
      text: '一个月前',
      value: () => {
        const date = new Date()
        date.setTime(date.getTime() - 3600 * 1000 * 24 * 30)
        return date
      }
    }
  ]
}

const isFieldHidden = (field: FieldConfig): boolean => {
  if (!field.show_option) return false
  
  try {
    const [targetField, targetValue] = field.show_option.split('=')
    return formData.value.dynamic[targetField] !== targetValue
  } catch {
    return false
  }
}

const onFieldChange = (field: FieldConfig, value: any) => {
  emit('fieldChange', field, value)
}

const initFormData = () => {
  const dynamicData: Record<string, any> = {}
  
  fields.value.forEach(field => {
    switch (field.type) {
      case 'checkbox':
        dynamicData[field.name] = []
        break
      case 'switch':
        dynamicData[field.name] = false
        break
      case 'number':
        dynamicData[field.name] = field.min !== undefined ? field.min : 0
        break
      default:
        dynamicData[field.name] = ''
    }
  })

  formData.value.dynamic = dynamicData
}

const loadOptions = async () => {
  try {
    // 从字典API获取优先级选项
    const response = await http.get('options/ticketPriority')
    if (response.data && response.data.data) {
      priorityOptions.value = Array.isArray(response.data.data) ? response.data.data : []
    }
  } catch (error) {
    console.error('加载优先级选项失败:', error)
    // 加载失败时不设置默认选项
    priorityOptions.value = []
  }
}

const fetchTemplate = async (id: number) => {
  // 模板数据已通过props传递，无需单独获取
  console.warn('fetchTemplate方法已废弃，模板数据应通过props传递')
}

const validateForm = async (): Promise<boolean> => {
  if (!formRef.value) return false
  
  try {
    await formRef.value.validate()
    return true
  } catch {
    return false
  }
}

const submitForm = async () => {
  if (props.readonly) return

  const isValid = await validateForm()
  if (!isValid) {
    ElMessage.warning('请完善表单信息')
    return
  }

  submitting.value = true
  try {
    const template = props.templateData || templateInfo.value
    const submitData = {
      title: template?.ticket_name || '',
      content: '',
      priority: formData.value.priority,
      template_id: template?.id,
      status: TicketStatus.PENDING,
      form_data: JSON.stringify(formData.value.dynamic)
    }

    emit('submit', submitData)
  } finally {
    submitting.value = false
  }
}

const resetForm = () => {
  formRef.value?.resetFields()
  initFormData()
  emit('reset')
}

// 监听器
watch(() => props.templateData, (newData) => {
  if (newData) {
    templateInfo.value = newData
    nextTick(initFormData)
  }
}, { immediate: true })

// 生命周期
onMounted(() => {
  loadOptions()
  
  if (props.templateData) {
    templateInfo.value = props.templateData
    nextTick(initFormData)
  }
})

// 暴露方法
defineExpose({
  validate: validateForm,
  submit: submitForm,
  reset: resetForm,
  getFormData: () => formData.value,
  refreshPermissions
})

// 在全局对象上暴露刷新权限方法，方便调试
if (typeof window !== 'undefined') {
  // @ts-ignore
  window.refreshTicketPermissions = refreshPermissions
  // @ts-ignore
  window.forceRefreshAllPermissions = async () => {
    try {
      const newActions = await userStore.forceRefreshPermissions()
      return newActions
    } catch (error) {
      throw error
    }
  }
}
</script>

<style scoped>
.ticket-form {
  height: 100%;
  padding: 16px;
  background: var(--el-bg-color);
  border-radius: 8px;
  border: 1px solid var(--el-border-color-lighter);
  display: flex;
  flex-direction: column;
}

/* 头部区域 - 固定在顶部 */
.form-header {
  flex-shrink: 0;
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid var(--el-border-color-lighter);
}

.header-content {
  max-width: 80%;
  margin: 0 auto;
  padding: 0 16px;
}

.template-title {
  margin: 0 0 8px 0;
  font-size: 18px;
  font-weight: 600;
  color: var(--el-text-color-primary);
  text-align: center;
}

.template-desc {
  margin: 0 0 12px 0;
  color: var(--el-text-color-regular);
  line-height: 1.5;
}

.template-meta {
  display: flex;
  justify-content: left;
  gap: 8px;
}

/* 表单内容区域 - 可滚动 */
.form-content {
  flex: 1;
  min-height: 0;
  margin-bottom: 16px;
  overflow: hidden;
}

.form-scrollbar {
  height: 100%;
}

.dynamic-form {
  max-width: 80%;
  margin: 0 auto;
  padding: 0 16px;
}

.priority-section,
.dynamic-section {
  margin-bottom: 24px;
}

/* 表单项居中 */
.dynamic-form :deep(.el-form-item) {
  margin-bottom: 18px;
}

.dynamic-form :deep(.el-form-item__content) {
  text-align: center;
}

.dynamic-form :deep(.el-select),
.dynamic-form :deep(.el-input),
.dynamic-form :deep(.el-input-number),
.dynamic-form :deep(.el-date-picker) {
  width: 100%;  
}

/* 数字输入框样式优化 */
.dynamic-form :deep(.el-input-number) {
  width: 100%;
}

.dynamic-form :deep(.el-input-number .el-input__wrapper) {
  border-radius: 6px;
}

/* 日期选择器样式优化 */
.dynamic-form :deep(.el-date-picker) {
  width: 100%;
}

.dynamic-form :deep(.el-date-picker .el-input__wrapper) {
  border-radius: 6px;
}

/* 开关组件样式优化 */
.dynamic-form :deep(.el-switch) {
  margin: 8px 0;
}

.dynamic-form :deep(.el-radio-group),
.dynamic-form :deep(.el-checkbox-group) {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}

/* 按钮区域 - 固定在底部 */
.form-actions {
  flex-shrink: 0;
  border-top: 1px solid var(--el-border-color-lighter);
  padding-top: 16px;
  margin-top: auto;
}

.actions-content {
  text-align: center;
}

.actions-content .el-button {
  margin: 0 4px;
  min-width: 80px;
}

/* 空状态 */
.empty-content {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* 响应式设计 */
@media (max-width: 768px) {
  .ticket-form {
    padding: 12px;
  }
  
  .template-meta {
    flex-direction: column;
    align-items: center;
    gap: 4px;
  }
  
  .dynamic-form {
    padding: 0 8px;
  }
  
  .dynamic-form :deep(.el-select),
  .dynamic-form :deep(.el-input),
  .dynamic-form :deep(.el-input-number),
  .dynamic-form :deep(.el-date-picker) {
    max-width: 100%;
  }
  
  .actions-content .el-button {
    margin: 2px;
    min-width: 80px;
  }
}
</style>