<template>
  <div class="fields-edit-container">
    <el-form ref="formRef" :model="formData" :rules="formRules" label-width="120px" class="fields-form">
      <el-card shadow="never" class="fields-card">
        <template #header>
          <div class="card-header">
            <div class="header-left">
              <el-icon size="20" class="header-icon">
                <EditPen />
              </el-icon>
              <h3 class="card-title">
                {{ isEdit ? '编辑字段' : '添加字段' }}
              </h3>
            </div>
            <div class="card-actions">
              <el-button @click="handleCancel">
                <el-icon>
                  <Close />
                </el-icon>
                取消
              </el-button>
              <el-button type="primary" :loading="loading" @click="handleSave">
                <el-icon>
                  <Check v-if="isEdit" />
                  <Plus v-else />
                </el-icon>
                {{ isEdit ? '保存' : '添加' }}
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
                 <el-form-item label="字段名称" prop="name">
                   <template #label>
                     <span>字段名称</span>
                     <el-tooltip content="用于系统内部标识，只能包含字母、数字和下划线" placement="top">
                       <el-icon class="help-icon">
                         <QuestionFilled />
                       </el-icon>
                     </el-tooltip>
                   </template>
                   <el-input v-model="formData.name" placeholder="请输入字段名称" :prefix-icon="EditPen" clearable />
                 </el-form-item>
               </el-col>
               <el-col :span="12">
                 <el-form-item label="显示名称" prop="label">
                   <template #label>
                     <span>显示名称</span>
                     <el-tooltip content="用户界面中显示的字段名称" placement="top">
                       <el-icon class="help-icon">
                         <QuestionFilled />
                       </el-icon>
                     </el-tooltip>
                   </template>
                   <el-input v-model="formData.label" placeholder="请输入显示名称" :prefix-icon="Document" clearable />
                 </el-form-item>
               </el-col>
            </el-row>

            <el-row :gutter="20">
                             <el-col :span="12">
                 <el-form-item label="字段类型" prop="type">
                   <template #label>
                     <span>字段类型</span>
                     <el-tooltip content="选择适合的字段类型以提供最佳的用户体验" placement="top">
                       <el-icon class="help-icon">
                         <QuestionFilled />
                       </el-icon>
                     </el-tooltip>
                   </template>
                   <el-select v-model="formData.type" placeholder="请选择字段类型" style="width: 100%">
                     <el-option v-for="type in fieldTypes" :key="type.value" :label="type.label" :value="type.value">
                       <div class="option-content">
                         <el-icon size="16">
                           <component :is="getFieldTypeIcon(type.value)" />
                         </el-icon>
                         <span>{{ type.label }}</span>
                       </div>
                     </el-option>
                   </el-select>
                 </el-form-item>
               </el-col>
               <el-col :span="12">
                 <el-form-item label="是否必填">
                   <template #label>
                     <span>是否必填</span>
                     <el-tooltip content="启用后用户必须填写此字段才能提交表单" placement="top">
                       <el-icon class="help-icon">
                         <QuestionFilled />
                       </el-icon>
                     </el-tooltip>
                   </template>
                   <el-switch v-model="formData.required" />
                 </el-form-item>
               </el-col>
            </el-row>

                                     <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="占位符">
                  <template #label>
                    <span>占位符</span>
                    <el-tooltip content="为用户提供输入提示和示例" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input v-model="formData.placeholder" placeholder="请输入占位符文本" :prefix-icon="ChatDotRound" />
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="最大长度">
                  <template #label>
                    <span>最大长度</span>
                    <el-tooltip content="限制输入内容的最大字符数" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="formData.maxlength" :min="0" :max="9999" placeholder="无限制" style="width: 100%" />
                </el-form-item>
              </el-col>
            </el-row>

            <!-- 字段特定配置 -->
            <el-row v-if="fieldTypeUtils.isTextType(formData.type)" :gutter="20">
              <el-col :span="12">
                <el-form-item label="显示字数统计">
                  <template #label>
                    <span>显示字数统计</span>
                    <el-tooltip content="在输入框下方显示已输入字符数" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-switch v-model="formData.showWordLimit" />
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item v-if="formData.type === 'textarea'" label="行数">
                  <template #label>
                    <span>行数</span>
                    <el-tooltip content="设置文本域的行数" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="formData.rows" :min="2" :max="20" style="width: 100%" />
                </el-form-item>
              </el-col>
            </el-row>

            <el-row v-if="fieldTypeUtils.isNumberType(formData.type)" :gutter="20">
              <el-col :span="8">
                <el-form-item label="最小值">
                  <template #label>
                    <span>最小值</span>
                    <el-tooltip content="设置数字输入的最小值" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="formData.min" :precision="2" style="width: 100%" />
                </el-form-item>
              </el-col>
              <el-col :span="8">
                <el-form-item label="最大值">
                  <template #label>
                    <span>最大值</span>
                    <el-tooltip content="设置数字输入的最大值" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="formData.max" :precision="2" style="width: 100%" />
                </el-form-item>
              </el-col>
              <el-col :span="8">
                <el-form-item label="步长">
                  <template #label>
                    <span>步长</span>
                    <el-tooltip content="设置数字输入的步长值" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="formData.step" :min="0.01" :precision="2" style="width: 100%" />
                </el-form-item>
              </el-col>
            </el-row>

            <el-row v-if="fieldTypeUtils.isNumberType(formData.type)" :gutter="20">
              <el-col :span="12">
                <el-form-item label="精度">
                  <template #label>
                    <span>精度</span>
                    <el-tooltip content="设置小数点后的位数" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="formData.precision" :min="0" :max="10" style="width: 100%" />
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="显示控制按钮">
                  <template #label>
                    <span>显示控制按钮</span>
                    <el-tooltip content="是否显示数字输入框的加减按钮" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-switch v-model="formData.controls" />
                </el-form-item>
              </el-col>
            </el-row>

            <el-row v-if="fieldTypeUtils.isDateType(formData.type)" :gutter="20">
              <el-col :span="12">
                <el-form-item label="日期格式">
                  <template #label>
                    <span>日期格式</span>
                    <el-tooltip content="设置日期的显示和存储格式" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-select v-model="formData.valueFormat" placeholder="请选择日期格式" style="width: 100%">
                    <el-option label="YYYY-MM-DD" value="YYYY-MM-DD" />
                    <el-option label="YYYY/MM/DD" value="YYYY/MM/DD" />
                    <el-option label="YYYY年MM月DD日" value="YYYY年MM月DD日" />
                    <el-option label="MM/DD/YYYY" value="MM/DD/YYYY" />
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="显示快捷选项">
                  <template #label>
                    <span>显示快捷选项</span>
                    <el-tooltip content="是否显示今天、昨天等快捷选项" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-switch v-model="formData.showShortcuts" />
                </el-form-item>
              </el-col>
            </el-row>

            <el-row v-if="fieldTypeUtils.isSwitchType(formData.type)" :gutter="20">
              <el-col :span="12">
                <el-form-item label="开启文本">
                  <template #label>
                    <span>开启文本</span>
                    <el-tooltip content="开关开启时显示的文本" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input v-model="formData.activeText" placeholder="是" />
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="关闭文本">
                  <template #label>
                    <span>关闭文本</span>
                    <el-tooltip content="开关关闭时显示的文本" placement="top">
                      <el-icon class="help-icon">
                        <QuestionFilled />
                      </el-icon>
                    </el-tooltip>
                  </template>
                  <el-input v-model="formData.inactiveText" placeholder="否" />
                </el-form-item>
              </el-col>
            </el-row>
          </el-card>

          <!-- 选项配置 -->
          <el-card v-if="fieldTypeUtils.hasOptions(formData.type)" class="form-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <List />
                </el-icon>
                <el-text tag="b">选项配置</el-text>
                <el-button type="primary" size="small" @click="addOption">
                  <el-icon>
                    <Plus />
                  </el-icon>
                  添加选项
                </el-button>
              </div>
            </template>

            <div class="options-section">
              <div v-if="tempOptions.length === 0" class="empty-state">
                <el-empty description="暂无选项配置" :image-size="60">
                  <el-button type="primary" @click="addOption">添加第一个选项</el-button>
                </el-empty>
              </div>

              <div v-else class="options-list">
                <div v-for="(option, index) in tempOptions" :key="index" class="option-item">
                  <el-input v-model="tempOptions[index]" size="default" :placeholder="`选项${index + 1}`"
                    class="option-input" :prefix-icon="List" />
                  <el-button size="default" type="danger" text @click="removeOption(index)">
                    <el-icon>
                      <Delete />
                    </el-icon>
                  </el-button>
                </div>
              </div>

              <el-form-item prop="options" style="display: none;">
                <el-input v-model="formData.options" />
              </el-form-item>
            </div>
          </el-card>

          <!-- 显示规则配置 -->
          <el-card v-if="fieldTypeUtils.hasShowOption(formData.type)" class="form-section" shadow="never">
            <template #header>
              <div class="section-header">
                <el-icon size="16" class="section-icon">
                  <Setting />
                </el-icon>
                <el-text tag="b">显示规则配置</el-text>
                <el-button type="primary" size="small" @click="addShowRule">
                  <el-icon>
                    <Plus />
                  </el-icon>
                  添加规则
                </el-button>
              </div>
            </template>

            <div class="show-rules-section">
              <div v-if="tempShowRules.length === 0" class="empty-state">
                <el-empty description="暂无显示规则" :image-size="60">
                  <el-button type="primary" @click="addShowRule">添加第一个规则</el-button>
                </el-empty>
              </div>

              <div v-else class="show-rules-list">
                <el-card v-for="(rule, index) in tempShowRules" :key="index" shadow="hover" class="rule-card">
                  <template #header>
                    <div class="rule-header">
                      <div class="rule-title">
                        <el-icon size="16" class="rule-icon">
                          <Setting />
                        </el-icon>
                        <el-text tag="b">规则 {{ index + 1 }}</el-text>
                      </div>
                      <el-button size="small" type="danger" text @click="removeShowRule(index)"
                        :disabled="tempShowRules.length <= 1">
                        <el-icon>
                          <Delete />
                        </el-icon>
                        删除
                      </el-button>
                    </div>
                  </template>

                  <el-row :gutter="16">
                    <el-col :span="12">
                      <el-form-item label="当选项值为" label-position="top">
                        <div class="label-with-tooltip">
                          <span>当选项值为</span>
                          <el-tooltip content="选择触发隐藏规则的选项值" placement="top">
                            <el-icon class="help-icon">
                              <QuestionFilled />
                            </el-icon>
                          </el-tooltip>
                        </div>
                        <el-select v-model="rule.optionValue" placeholder="选择选项值" style="width: 100%">
                          <el-option v-for="option in getCurrentFieldOptions" :key="option" :label="option" :value="option" />
                        </el-select>
                      </el-form-item>
                    </el-col>
                    <el-col :span="12">
                      <el-form-item label="隐藏目标字段" label-position="top">
                        <div class="label-with-tooltip">
                          <span>隐藏目标字段</span>
                          <el-tooltip content="当条件满足时将被隐藏的字段" placement="top">
                            <el-icon class="help-icon">
                              <QuestionFilled />
                            </el-icon>
                          </el-tooltip>
                        </div>
                        <el-select v-model="rule.targetFields" placeholder="选择要隐藏的字段" style="width: 100%" multiple>
                          <el-option v-for="targetField in availableTargetFields" :key="targetField.name"
                            :label="`${targetField.label} (${targetField.name})`" :value="targetField.name" />
                        </el-select>
                      </el-form-item>
                    </el-col>
                  </el-row>
                </el-card>
              </div>

              <el-form-item prop="show_option" style="display: none;">
                <el-input v-model="formData.show_option" />
              </el-form-item>
            </div>
          </el-card>
        </div>
      </el-card>
    </el-form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, watch } from 'vue'
import { type FormInstance, type FormRules } from 'element-plus'
import { ElMessage } from 'element-plus'
import {
  Plus,
  Delete,
  EditPen,
  Document,
  List,
  Setting,
  ChatDotRound,
  Close,
  Check,
  Edit,
  Calendar,
  Select,
  CircleCheck,
  Checked,
  Switch,
  OfficeBuilding,
  User,
  QuestionFilled
} from '@element-plus/icons-vue'
import http from '@/support/http'


// 字段配置接口
interface FieldConfig {
  name: string
  label: string
  type: FieldType
  placeholder: string
  required: boolean
  options: string
  show_option?: string
  // 新增配置选项
  maxlength?: number
  showWordLimit?: boolean
  rows?: number
  min?: number
  max?: number
  step?: number
  precision?: number
  controls?: boolean
  valueFormat?: string
  showShortcuts?: boolean
  activeText?: string
  inactiveText?: string
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

// 隐藏规则接口
interface HideRule {
  optionValue: string
  targetFields: string[]
}

// 字段类型配置
const OPTIONS_TYPES: FieldType[] = ['select', 'radio', 'checkbox']
const SHOW_OPTION_TYPES: FieldType[] = ['select', 'radio']

// 字段类型选项
const FIELD_TYPES = [
  { label: '文本输入', value: 'text' },
  { label: '多行文本', value: 'textarea' },
  { label: '数字输入', value: 'number' },
  { label: '日期选择', value: 'date' },
  { label: '下拉选择', value: 'select' },
  { label: '单选按钮', value: 'radio' },
  { label: '多选按钮', value: 'checkbox' },
  { label: '开关', value: 'switch' },
  { label: '部门选择', value: 'department' },
  { label: '职位选择', value: 'position' }
]

// 工具函数
const fieldTypeUtils = {
  hasOptions: (type: FieldType): boolean => OPTIONS_TYPES.includes(type),
  hasShowOption: (type: FieldType): boolean => SHOW_OPTION_TYPES.includes(type),
  isTextType: (type: FieldType): boolean => ['text', 'textarea'].includes(type),
  isNumberType: (type: FieldType): boolean => ['number'].includes(type),
  isDateType: (type: FieldType): boolean => ['date'].includes(type),
  isSwitchType: (type: FieldType): boolean => ['switch'].includes(type)
}

const optionUtils = {
  parseOptions: (options: string): string[] =>
    options ? options.split(/[,\n]/).map(opt => opt.trim()).filter(Boolean) : []
}

const showRuleUtils = {
  parseShowOption: (showOption: string): HideRule[] => {
    if (!showOption) return []

    return showOption.split(';')
      .filter(rule => rule.trim())
      .map(rule => {
        if (rule.includes('|')) {
          const [optionValue, targetFields] = rule.split('|')
          return {
            optionValue: optionValue.trim(),
            targetFields: targetFields ? targetFields.split(',').map(f => f.trim()) : []
          }
        }
        return { optionValue: '', targetFields: [] }
      })
  },

  formatShowOption: (rules: HideRule[]): string => {
    const validRules = rules.filter(rule =>
      rule.optionValue && rule.targetFields.length > 0
    )

    return validRules.map(rule =>
      `${rule.optionValue}|${rule.targetFields.join(',')}`
    ).join(';')
  }
}

const jsonUtils = {
  generateFieldsSchema: (fields: FieldConfig[]): string => {
    const schema = fields.map(field => {
      const fieldSchema: any = {
        name: field.name,
        label: field.label,
        type: field.type,
        required: field.required
      }

      if (field.placeholder) fieldSchema.placeholder = field.placeholder
      if (field.options && fieldTypeUtils.hasOptions(field.type)) {
        fieldSchema.options = optionUtils.parseOptions(field.options)
      }
      if (field.show_option && fieldTypeUtils.hasShowOption(field.type)) {
        fieldSchema.show_option = field.show_option
      }

      return fieldSchema
    })

    return JSON.stringify(schema, null, 2)
  }
}

const props = defineProps<{
  field?: FieldConfig | null
  allFields?: FieldConfig[]
  selectedTemplate?: any
}>()

const emit = defineEmits<{
  save: [field: FieldConfig]
  cancel: []
  refresh: []
}>()

const formRef = ref<FormInstance>()
const loading = ref(false)
const isEdit = computed(() => !!props.field?.name)

const formData = ref<FieldConfig>({
  name: '',
  label: '',
  type: 'text',
  placeholder: '',
  required: false,
  options: '',
  show_option: '',
  // 新增配置选项的默认值
  maxlength: undefined,
  showWordLimit: false,
  rows: 3,
  min: undefined,
  max: undefined,
  step: 1,
  precision: undefined,
  controls: true,
  valueFormat: 'YYYY-MM-DD',
  showShortcuts: false,
  activeText: '是',
  inactiveText: '否'
})

const tempOptions = ref<string[]>([])
const tempShowRules = ref<HideRule[]>([])

const fieldTypes = computed(() => FIELD_TYPES)

const getCurrentFieldOptions = computed(() => {
  if (!formData.value) return []

  if (formData.value.type === 'switch') {
    return ['true', 'false']
  }

  return optionUtils.parseOptions(formData.value.options || '')
})

const availableTargetFields = computed(() => {
  if (!props.allFields) return []
  return props.allFields.filter(f => f.name !== formData.value?.name)
})

// 获取字段类型图标
const getFieldTypeIcon = (type: string) => {
  const iconMap: Record<string, any> = {
    text: Edit,
    textarea: Document,
    number: Edit,
    date: Calendar,
    select: Select,
    radio: CircleCheck,
    checkbox: Checked,
    switch: Switch,
    department: OfficeBuilding,
    position: User
  }
  return iconMap[type] || Edit
}

const formRules: FormRules = {
  name: [
    { required: true, message: '请输入字段名称', trigger: 'blur' },
    { pattern: /^[a-zA-Z_][a-zA-Z0-9_]*$/, message: '字段名称只能包含字母、数字和下划线，且不能以数字开头', trigger: 'blur' }
  ],
  label: [
    { required: true, message: '请输入显示名称', trigger: 'blur' }
  ],
  type: [
    { required: true, message: '请选择字段类型', trigger: 'change' }
  ],
  options: [
    {
      validator: (rule, value, callback) => {
        if (fieldTypeUtils.hasOptions(formData.value.type) && !value.trim()) {
          callback(new Error('选项配置不能为空'))
        } else {
          callback()
        }
      },
      trigger: 'blur'
    }
  ],
  show_option: [
    {
      validator: (rule, value, callback) => {
        if (fieldTypeUtils.hasShowOption(formData.value.type) && !value.trim()) {
          callback(new Error('显示规则配置不能为空'))
        } else {
          callback()
        }
      },
      trigger: 'blur'
    }
  ]
}

const addOption = () => {
  const newOptionIndex = tempOptions.value.length + 1
  tempOptions.value.push(`选项${newOptionIndex}`)
  updateOptionsText()
}

const removeOption = (index: number) => {
  tempOptions.value.splice(index, 1)
  updateOptionsText()
}

const updateOptionsText = () => {
  formData.value.options = tempOptions.value
    .filter(opt => opt.trim())
    .map(opt => opt.trim())
    .join(',')
}

const addShowRule = () => {
  tempShowRules.value.push({ optionValue: '', targetFields: [] })
}

const removeShowRule = (index: number) => {
  if (tempShowRules.value.length > 1) {
    tempShowRules.value.splice(index, 1)
  }
  updateShowRulesText()
}

const updateShowRulesText = () => {
  formData.value.show_option = showRuleUtils.formatShowOption(tempShowRules.value)
}

const handleCancel = () => {
  emit('cancel')
}

const handleSave = async () => {
  if (!formRef.value) return

  try {
    await formRef.value.validate()
    loading.value = true

    if (fieldTypeUtils.hasOptions(formData.value.type)) {
      updateOptionsText()
    }

    if (fieldTypeUtils.hasShowOption(formData.value.type)) {
      updateShowRulesText()
    }

    // 直接保存到数据库
    await saveFieldToDatabase()

    emit('save', { ...formData.value })
  } catch (error) {
    ElMessage.error('保存失败，请检查表单填写是否完整')
  } finally {
    loading.value = false
  }
}

const saveFieldToDatabase = async () => {
  if (!props.selectedTemplate?.id) {
    ElMessage.error('请先选择模板')
    return
  }

  try {
    // 获取当前模板的所有字段（包括当前正在编辑的字段）
    const currentFields = props.allFields || []
    let updatedFields = [...currentFields]

    if (isEdit.value && props.field?.name) {
      // 编辑模式：更新现有字段，保持原有顺序
      const index = updatedFields.findIndex(f => f.name === props.field?.name)
      if (index !== -1) {
        // 在原有位置更新字段
        updatedFields[index] = { ...formData.value }
      } else {
        // 如果找不到要编辑的字段，则添加到末尾
        updatedFields.push({ ...formData.value })
      }
    } else {
      // 添加模式：添加新字段到末尾
      updatedFields.push({ ...formData.value })
    }

    // 生成JSON Schema
    const schema = jsonUtils.generateFieldsSchema(updatedFields)

    // 保存到数据库
    const response = await http.put(`tickets/ticket/templates/${props.selectedTemplate.id}/form-config`, {
      ticket_form: schema
    })

    if (response.data.code === 200) {
      ElMessage.success(isEdit.value ? '字段更新成功' : '字段添加成功')
      emit('refresh')
    } else {
      ElMessage.error(response.data.message || '保存失败')
    }
  } catch (error: any) {
    console.error('保存失败:', error)
    ElMessage.error(error.response?.data?.message || '保存失败')
  }
}

watch(tempOptions, () => {
  updateOptionsText()
}, { deep: true })

watch(tempShowRules, () => {
  updateShowRulesText()
}, { deep: true })

watch(() => formData.value.type, (newType) => {
  if (fieldTypeUtils.hasOptions(newType)) {
    tempOptions.value = optionUtils.parseOptions(formData.value.options || '')
    if (tempOptions.value.length === 0) {
      tempOptions.value = ['选项1']
    }
  }

  if (fieldTypeUtils.hasShowOption(newType)) {
    tempShowRules.value = showRuleUtils.parseShowOption(formData.value.show_option || '')
    if (tempShowRules.value.length === 0) {
      tempShowRules.value = [{ optionValue: '', targetFields: [] }]
    }
  }
})

watch(() => props.field, (field) => {
  if (field) {
    formData.value = { ...field }

    if (fieldTypeUtils.hasOptions(field.type)) {
      tempOptions.value = optionUtils.parseOptions(field.options || '')
      if (tempOptions.value.length === 0) {
        tempOptions.value = ['选项1']
      }
    }

    if (fieldTypeUtils.hasShowOption(field.type)) {
      tempShowRules.value = showRuleUtils.parseShowOption(field.show_option || '')
      if (tempShowRules.value.length === 0) {
        tempShowRules.value = [{ optionValue: '', targetFields: [] }]
      }
    }
  } else {
    formData.value = {
      name: '',
      label: '',
      type: 'text',
      placeholder: '',
      required: false,
      options: '',
      show_option: '',
      // 重置新增配置选项
      maxlength: undefined,
      showWordLimit: false,
      rows: 3,
      min: undefined,
      max: undefined,
      step: 1,
      precision: undefined,
      controls: true,
      valueFormat: 'YYYY-MM-DD',
      showShortcuts: false,
      activeText: '是',
      inactiveText: '否'
    }
    tempOptions.value = []
    tempShowRules.value = []
  }
}, { immediate: true })
</script>

<style scoped>
.fields-edit-container {
  height: 100%;
  overflow-y: auto;
  padding: 0;
  background: linear-gradient(135deg, var(--el-fill-color-lighter) 0%, var(--el-fill-color-light) 100%);
}

.fields-form {
  width: 100%;
  height: 100%;
}

.fields-card {
  border-radius: 12px;
  border: none;
  box-shadow: 0 8px 32px var(--el-box-shadow-light);
  height: 100%;
  backdrop-filter: blur(10px);
  background: var(--el-bg-color);
}

.fields-card :deep(.el-card__body) {
  padding: 0;
  height: 100%;
}

.fields-card :deep(.el-card__header) {
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
  justify-content: space-between;
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

.help-icon {
  color: var(--el-color-primary);
  font-size: 14px;
  cursor: help;
  transition: all 0.2s ease;
}

.help-icon:hover {
  color: var(--el-color-primary-dark-2);
  transform: scale(1.1);
}

/* 表单字段样式优化 */
:deep(.el-form-item__label) {
  font-weight: 500;
  color: var(--el-text-color-primary);
  display: flex;
  align-items: center;
  gap: 6px;
}

/* 配置选项样式 */
:deep(.el-input-number) {
  width: 100%;
}

:deep(.el-switch) {
  margin-top: 4px;
}

/* 字段特定配置区域样式 */
.form-section .el-row {
  margin-bottom: 16px;
}

.form-section .el-row:last-child {
  margin-bottom: 0;
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

/* 选项配置样式 */
.options-section,
.show-rules-section {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.empty-state {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 120px;
}

.options-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.option-item {
  display: flex;
  align-items: center;
  gap: 12px;
}

.option-input {
  flex: 1;
}

/* 显示规则配置样式 */
.show-rules-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.rule-card {
  border: 1px solid var(--el-border-color);
  transition: all 0.2s ease;
  border-radius: 8px;
}

.rule-card:hover {
  border-color: var(--el-color-primary);
  box-shadow: 0 2px 8px var(--el-box-shadow-light);
}

.rule-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.rule-title {
  display: flex;
  align-items: center;
  gap: 8px;
}

.rule-icon {
  color: var(--el-color-primary);
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

  .section-header {
    flex-direction: column;
    gap: 12px;
    align-items: flex-start;
  }
}
</style>
