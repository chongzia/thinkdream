<template>
  <div class="save-template-container">
    <el-form ref="formRef" :model="formData" :rules="formRules" label-width="120px" class="template-form">
      <el-card shadow="never" class="template-card">
        <template #header>
          <div class="card-header">
            <div class="header-left">
              <el-icon size="20" class="header-icon">
                <Collection />
              </el-icon>
              <h3 class="card-title">
                {{ formData.ticket_name || (isEditMode ? '编辑模板' : '新建模板') }}
              </h3>
            </div>
            <div class="card-actions">
              <el-button @click="handleCancel">
                <el-icon>
                  <Close />
                </el-icon>
                取消
              </el-button>
              <el-button type="primary" :loading="loading" @click="handleSubmit">
                <el-icon>
                  <Check v-if="isEditMode" />
                  <Plus v-else />
                </el-icon>
                {{ isEditMode ? '保存' : '创建' }}
              </el-button>
            </div>
          </div>
        </template>

        <div class="form-content">
          <!-- 基础信息 -->
          <el-card class="form-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <Document />
                </el-icon>
                <el-text tag="b">基础信息</el-text>
              </div>
            </template>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="模板名称" prop="ticket_name">
                  <el-input v-model="formData.ticket_name" placeholder="请输入模板名称" :prefix-icon="Document" clearable />
                  <div class="field-tip">用于标识和区分不同的工单模板</div>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="模板状态" prop="ticket_is_active">
                  <el-select v-model="formData.ticket_is_active" placeholder="请选择模板状态" style="width: 100%">
                    <el-option v-for="option in statusOptions" :key="option.value" :label="option.label"
                      :value="option.value">
                      <div class="option-content">
                        <el-icon :color="option.value === 1 ? 'var(--el-color-success)' : 'var(--el-color-danger)'">
                          <CircleCheck v-if="option.value === 1" />
                          <CircleClose v-else />
                        </el-icon>
                        <span>{{ option.label }}</span>
                      </div>
                    </el-option>
                  </el-select>
                  <div class="field-tip">启用后该模板可用于创建工单</div>
                </el-form-item>
              </el-col>
            </el-row>
            <el-row :gutter="20">
              <el-col :span="24">
                <el-form-item label="模板描述">
                  <el-input v-model="formData.ticket_description" type="textarea" placeholder="请输入模板描述，用于说明该模板的用途和特点..."
                    :rows="4" :maxlength="500" show-word-limit resize="vertical" style="width: 100%" />
                </el-form-item>
              </el-col>
            </el-row>
          </el-card>

          <!-- 人员配置 -->
          <el-card class="form-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <UserFilled />
                </el-icon>
                <el-text tag="b">人员配置</el-text>
              </div>
            </template>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="受理人" prop="ticket_accept">
                  <el-select v-model="formData.ticket_accept" placeholder="请选择受理人" style="width: 100%" clearable>
                    <el-option label="系统管理员" :value="1">
                      <div class="option-content">
                        <el-icon size="16">
                          <User />
                        </el-icon>
                        <span>系统管理员</span>
                      </div>
                    </el-option>
                    <el-option label="技术支持" :value="2">
                      <div class="option-content">
                        <el-icon size="16">
                          <Tools />
                        </el-icon>
                        <span>技术支持</span>
                      </div>
                    </el-option>
                    <el-option label="客服人员" :value="3">
                      <div class="option-content">
                        <el-icon size="16">
                          <Service />
                        </el-icon>
                        <span>客服人员</span>
                      </div>
                    </el-option>
                  </el-select>
                  <div class="field-tip">负责接收和处理工单的主要人员</div>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="流程处理人" prop="ticket_process">
                  <el-select v-model="formData.ticket_process" placeholder="请选择流程处理人" style="width: 100%" multiple
                    clearable collapse-tags collapse-tags-tooltip>
                    <el-option label="系统管理员" :value="1">
                      <div class="option-content">
                        <el-icon size="16">
                          <User />
                        </el-icon>
                        <span>系统管理员</span>
                      </div>
                    </el-option>
                    <el-option label="技术支持" :value="2">
                      <div class="option-content">
                        <el-icon size="16">
                          <Tools />
                        </el-icon>
                        <span>技术支持</span>
                      </div>
                    </el-option>
                    <el-option label="客服人员" :value="3">
                      <div class="option-content">
                        <el-icon size="16">
                          <Service />
                        </el-icon>
                        <span>客服人员</span>
                      </div>
                    </el-option>
                  </el-select>
                  <div class="field-tip">参与工单处理流程的相关人员</div>
                </el-form-item>
              </el-col>
            </el-row>
          </el-card>

          <!-- 时间配置 -->
          <el-card class="form-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <Clock />
                </el-icon>
                <el-text tag="b">时间配置</el-text>
              </div>
            </template>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="受理时限(天)" prop="ticket_accept_days">
                  <el-input-number v-model="formData.ticket_accept_days" :min="1" :max="365" style="width: 100%"
                    :controls="true" placeholder="请输入受理时限" />
                  <div class="field-tip">从工单提交到受理的时间限制</div>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="处理时限(天)" prop="ticket_process_days">
                  <el-input-number v-model="formData.ticket_process_days" :min="1" :max="365" style="width: 100%"
                    :controls="true" placeholder="请输入处理时限" />
                  <div class="field-tip">从受理到处理完成的时间限制</div>
                </el-form-item>
              </el-col>
            </el-row>
          </el-card>


        </div>
      </el-card>
    </el-form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, watch, onMounted } from 'vue'
import { ElMessage, type FormInstance, type FormRules } from 'element-plus'
import {
  Plus,
  Close,
  Check,
  Document,
  UserFilled,
  User,
  Tools,
  Service,
  Clock,
  CircleCheck,
  CircleClose,
  Collection
} from '@element-plus/icons-vue'
import http from '@/support/http'

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

// 表单数据接口（用于保存模板）
interface FormData {
  ticket_name: string
  ticket_description: string
  ticket_accept: number | undefined
  ticket_process: number[] | undefined
  ticket_accept_days: number
  ticket_process_days: number
  ticket_is_active: number
}

// 状态选项接口
interface StatusOption {
  label: string
  value: number
}

// 默认表单数据
const DEFAULT_FORM_DATA = {
  ticket_accept_days: 3,
  ticket_process_days: 7,
  ticket_is_active: 1
}

const props = defineProps<{
  template?: TemplateData | null
}>()

const emit = defineEmits<{
  close: []
  success: [data: TemplateData]
}>()

const formRef = ref<FormInstance>()
const loading = ref(false)
const statusOptions = ref<StatusOption[]>([])

const formData = ref<FormData>({
  ticket_name: '',
  ticket_description: '',
  ticket_accept: undefined,
  ticket_process: undefined,
  ticket_accept_days: DEFAULT_FORM_DATA.ticket_accept_days,
  ticket_process_days: DEFAULT_FORM_DATA.ticket_process_days,
  ticket_is_active: DEFAULT_FORM_DATA.ticket_is_active
})

const isEditMode = computed(() => !!props.template?.id)

const formRules: FormRules = {
  ticket_name: [
    { required: true, message: '请输入模板名称', trigger: 'blur' }
  ],
  ticket_accept: [
    { required: true, message: '请选择受理人', trigger: 'change' }
  ],
  ticket_process: [
    { required: true, message: '请选择流程处理人', trigger: 'change' }
  ],
  ticket_accept_days: [
    { required: true, message: '请设置受理时限', trigger: 'blur' }
  ],
  ticket_process_days: [
    { required: true, message: '请设置处理时限', trigger: 'blur' }
  ],
  ticket_is_active: [
    { required: true, message: '请选择模板状态', trigger: 'change' }
  ]
}

const getStatusOptions = () => {
  statusOptions.value = [
    { label: '启用', value: 1 },
    { label: '禁用', value: 0 }
  ]
}

const handleCancel = () => emit('close')

const handleSubmit = async () => {
  if (!formRef.value) return

  try {
    await formRef.value.validate()
    loading.value = true

    const submitData = {
      ...formData.value,
      ticket_process: Array.isArray(formData.value.ticket_process)
        ? formData.value.ticket_process.join(',')
        : ''
    }

    const response = isEditMode.value && props.template?.id
      ? await http.put(`tickets/ticket/templates/${props.template.id}`, submitData)
      : await http.post('tickets/ticket/templates', submitData)

    if (response.data?.code === 200) {
      ElMessage.success(isEditMode.value ? '模板保存成功' : '模板创建成功')
      emit('success', response.data.data)
    } else {
      ElMessage.error(response.data?.message || '保存失败')
    }
  } catch (error: any) {
    console.error('保存失败:', error)
    ElMessage.error(error.response?.data?.message || '保存失败')
  } finally {
    loading.value = false
  }
}

const resetFormData = () => {
  formData.value = {
    ticket_name: '',
    ticket_description: '',
    ticket_accept: undefined,
    ticket_process: undefined,
    ticket_accept_days: DEFAULT_FORM_DATA.ticket_accept_days,
    ticket_process_days: DEFAULT_FORM_DATA.ticket_process_days,
    ticket_is_active: DEFAULT_FORM_DATA.ticket_is_active
  }
}

const loadTemplateData = (template: TemplateData) => {
  const processUsers = typeof template.ticket_process === 'string'
    ? template.ticket_process.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id))
    : Array.isArray(template.ticket_process) ? template.ticket_process : undefined

  formData.value = {
    ticket_name: template.ticket_name || '',
    ticket_description: template.ticket_description || '',
    ticket_accept: template.ticket_accept || undefined,
    ticket_process: processUsers,
    ticket_accept_days: template.ticket_accept_days || DEFAULT_FORM_DATA.ticket_accept_days,
    ticket_process_days: template.ticket_process_days || DEFAULT_FORM_DATA.ticket_process_days,
    ticket_is_active: template.ticket_is_active ?? DEFAULT_FORM_DATA.ticket_is_active
  }
}

watch(() => props.template, (newTemplate) => {
  if (newTemplate) {
    loadTemplateData(newTemplate)
  } else {
    resetFormData()
  }
}, { immediate: true })

onMounted(() => {
  getStatusOptions()
})
</script>

<style scoped>
.save-template-container {
  height: 100%;
  overflow-y: auto;
  padding: 0;
  background: linear-gradient(135deg, var(--el-fill-color-lighter) 0%, var(--el-fill-color-light) 100%);
}

.template-form {
  width: 100%;
  height: 100%;
}

.template-card {
  border-radius: 12px;
  border: none;
  box-shadow: 0 8px 32px var(--el-box-shadow-light);
  height: 100%;
  backdrop-filter: blur(10px);
  background: var(--el-bg-color);
}

.template-card :deep(.el-card__body) {
  padding: 0;
  height: 100%;
}

.template-card :deep(.el-card__header) {
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

.card-actions {
  display: flex;
  gap: 12px;
}

.form-content {
  padding: 24px;
  height: calc(100% - 88px);
  overflow-y: auto;
}

.form-section {
  margin-bottom: 24px;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.form-section:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px var(--el-box-shadow-light);
}

.form-section:last-child {
  margin-bottom: 0;
}

.form-section :deep(.el-card__header) {
  background: linear-gradient(135deg, var(--el-fill-color-light) 0%, var(--el-fill-color-lighter) 100%);
  border-bottom: 1px solid var(--el-border-color-lighter);
  border-radius: 8px 8px 0 0;
  padding: 16px 20px;
  margin-bottom: 10px;
}

.form-section :deep(.el-card__body) {
  padding: 20px;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 10px;
}

.section-icon {
  color: var(--el-color-primary);
}

.option-content {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 4px 0;
}

/* 按钮图标样式 */
.card-actions .el-button .el-icon {
  font-size: 16px;
  margin-right: 4px;
}

/* 图标样式统一 */
.option-content .el-icon,
.section-icon,
.header-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.option-content .el-icon {
  font-size: 16px;
}

.section-icon {
  font-size: 16px;
}

.header-icon {
  font-size: 20px;
}

.field-tip {
  font-size: 12px;
  color: var(--el-text-color-secondary);
  margin-top: 6px;
  padding: 4px 8px;
  background: var(--el-fill-color-lighter);
  border-radius: 4px;
  border-left: 3px solid var(--el-color-primary-light-5);
}

/* 表单字段样式优化 */
:deep(.el-form-item__label) {
  font-weight: 500;
  color: var(--el-text-color-primary);
}

:deep(.el-input__wrapper) {
  border-radius: 6px;
  transition: all 0.3s ease;
}

:deep(.el-input__wrapper:hover) {
  box-shadow: 0 0 0 1px var(--el-color-primary-light-5);
}

:deep(.el-input__wrapper.is-focus) {
  box-shadow: 0 0 0 1px var(--el-color-primary);
}

:deep(.el-select .el-input__wrapper),
:deep(.el-input-number .el-input__wrapper) {
  border-radius: 6px;
}

/* 滚动条样式 */
.form-content::-webkit-scrollbar {
  width: 6px;
}

.form-content::-webkit-scrollbar-track {
  background: var(--el-fill-color-lighter);
  border-radius: 3px;
}

.form-content::-webkit-scrollbar-thumb {
  background: var(--el-color-primary-light-3);
  border-radius: 3px;
}

.form-content::-webkit-scrollbar-thumb:hover {
  background: var(--el-color-primary);
}

@media (max-width: 768px) {
  .card-header {
    flex-direction: column;
    gap: 16px;
    align-items: flex-start;
  }

  .card-actions {
    width: 100%;
    justify-content: flex-end;
  }

  .form-content {
    padding: 16px;
  }

  .form-section {
    margin-bottom: 16px;
  }
}
</style>
