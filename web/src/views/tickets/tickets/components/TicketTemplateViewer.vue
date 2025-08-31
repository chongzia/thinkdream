<template>
  <div class="template-viewer">
    <el-descriptions :column="2" border>
      <el-descriptions-item label="模板名称" :span="2">
        <strong>{{ templateData.ticket_name }}</strong>
      </el-descriptions-item>
      <el-descriptions-item label="模板描述" :span="2" v-if="templateData.ticket_description">
        <p class="template-description">{{ templateData.ticket_description }}</p>
      </el-descriptions-item>
      <el-descriptions-item label="受理天数">
        {{ templateData.ticket_accept_days }} 天
      </el-descriptions-item>
      <el-descriptions-item label="处理天数">
        {{ templateData.ticket_process_days }} 天
      </el-descriptions-item>
      <el-descriptions-item label="受理人ID">
        {{ templateData.ticket_accept }}
      </el-descriptions-item>
      <el-descriptions-item label="处理流程">
        {{ templateData.ticket_process || '无特殊流程' }}
      </el-descriptions-item>
    </el-descriptions>

    <!-- 表单字段结构 -->
    <div v-if="formFields.length > 0" class="template-fields">
      <h4>表单字段配置</h4>
      <el-table :data="formFields" border stripe>
        <el-table-column prop="name" label="字段名称" width="120" />
        <el-table-column prop="label" label="字段标签" width="150" />
        <el-table-column prop="type" label="字段类型" width="100">
          <template #default="{ row }">
            <el-tag size="small">{{ getFieldTypeLabel(row.type) }}</el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="required" label="是否必填" width="100">
          <template #default="{ row }">
            <el-tag :type="row.required ? 'danger' : 'info'" size="small">
              {{ row.required ? '必填' : '选填' }}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="placeholder" label="占位符" />
        <el-table-column prop="options" label="选项" width="200">
          <template #default="{ row }">
            <div v-if="row.options" class="field-options">
              <el-tag 
                v-for="option in parseOptions(row.options)" 
                :key="option"
                size="small"
                class="option-tag"
              >
                {{ option }}
              </el-tag>
            </div>
            <span v-else class="no-options">无选项</span>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'

interface TemplateData {
  id: number
  ticket_name: string
  ticket_description?: string
  ticket_form?: string | any[]
  ticket_accept: number
  ticket_process: string
  ticket_accept_days: number
  ticket_process_days: number
  ticket_is_active: number
}

interface Props {
  templateData: TemplateData
  mode?: 'readonly' | 'edit'
}

const props = withDefaults(defineProps<Props>(), {
  mode: 'readonly'
})

// 计算属性
const formFields = computed(() => {
  if (!props.templateData.ticket_form) return []
  
  try {
    const formConfig = typeof props.templateData.ticket_form === 'string'
      ? JSON.parse(props.templateData.ticket_form)
      : props.templateData.ticket_form
    
    return Array.isArray(formConfig) ? formConfig : []
  } catch (error) {
    console.error('解析表单配置失败:', error)
    return []
  }
})

// 方法
const getFieldTypeLabel = (type: string): string => {
  const typeLabels: Record<string, string> = {
    'text': '文本',
    'textarea': '多行文本',
    'number': '数字',
    'date': '日期',
    'select': '下拉选择',
    'radio': '单选框',
    'checkbox': '复选框',
    'switch': '开关',
    'department': '部门',
    'position': '岗位'
  }
  return typeLabels[type] || type
}

const parseOptions = (options: string): string[] => {
  if (!options) return []
  
  try {
    // 如果是JSON字符串格式的选项
    if (options.startsWith('[') || options.startsWith('{')) {
      const parsed = JSON.parse(options)
      if (Array.isArray(parsed)) {
        return parsed.map(item => typeof item === 'object' ? item.label || item.value : item)
      }
    }
    
    // 如果是逗号分隔的字符串
    return options.split(',').map(item => item.trim()).filter(Boolean)
  } catch (error) {
    // fallback: 直接按逗号分割
    return options.split(',').map(item => item.trim()).filter(Boolean)
  }
}
</script>

<style scoped>
.template-viewer {
  padding: 0;
}

.template-description {
  margin: 0;
  line-height: 1.6;
  color: var(--el-text-color-regular);
}

.template-fields {
  margin-top: 24px;
}

.template-fields h4 {
  margin: 0 0 16px 0;
  color: var(--el-text-color-primary);
  font-weight: 600;
}

.field-options {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
}

.option-tag {
  font-size: 11px;
}

.no-options {
  color: var(--el-text-color-placeholder);
  font-size: 12px;
  font-style: italic;
}

/* 表格样式调整 */
.el-table {
  font-size: 13px;
}

.el-table :deep(.el-table__cell) {
  padding: 8px 12px;
}
</style>