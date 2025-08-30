    <template>
      <div class="template-fields-table">

        <el-table 
          :data="fields" 
          style="width: 100%" 
          :empty-text="emptyText" 
          v-loading="loading"
          stripe
        >
          <el-table-column prop="name" label="字段名称" width="130" show-overflow-tooltip />
          <el-table-column prop="label" label="显示名称" width="130" show-overflow-tooltip />
          <el-table-column prop="type" label="字段类型" width="100" align="center">
            <template #default="{ row }">
              <el-tag size="small" :type="getTypeTagType(row.type)">
                {{ getTypeLabel(row.type) }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column prop="placeholder" label="占位符" show-overflow-tooltip />
          <el-table-column prop="required" label="必填" width="60" align="center">
            <template #default="{ row }">
              <el-tag size="small" :type="row.required ? 'danger' : 'info'">
                {{ row.required ? '是' : '否' }}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column prop="options" label="选项" width="80" align="center">
            <template #default="{ row }">
              <span v-if="row.options && row.options.trim()" class="options-count">
                {{ getOptionsCount(row.options) }}个选项
              </span>
              <span v-else class="no-options">无</span>
            </template>
          </el-table-column>
          <el-table-column prop="show_option" label="显示规则" width="80" align="center">
            <template #default="{ row }">
              <span v-if="row.show_option && row.show_option.trim()" class="rules-count">
                {{ getShowRulesCount(row.show_option) }}条规则
              </span>
              <span v-else class="no-rules">无</span>
            </template>
          </el-table-column>
          <el-table-column label="操作" width="290" fixed="right" align="center">
            <template #default="{ row, $index }">
              <el-space>
                <el-button v-if="hasTemplateUpdatePermission" size="small" type="primary" text @click="handleEdit(row)">
                  <el-icon size="14">
                    <Edit />
                  </el-icon>
                  编辑
                </el-button>
                <el-button v-if="hasTemplateUpdatePermission" size="small" type="danger" text @click="handleDelete(row, $index)">
                  <el-icon size="14">
                    <Delete />
                  </el-icon>
                  删除
                </el-button>
                <el-button v-if="hasTemplateUpdatePermission" size="small" type="info" text :disabled="$index === 0" @click="handleMoveUp($index)">
                  <el-icon size="14">
                    <ArrowUp />
                  </el-icon>
                  上移
                </el-button>
                <el-button v-if="hasTemplateUpdatePermission" size="small" type="info" text :disabled="$index === fields.length - 1"
                  @click="handleMoveDown($index)">
                  <el-icon size="14">
                    <ArrowDown />
                  </el-icon>
                  下移
                </el-button>
              </el-space>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import { ElMessageBox, ElMessage } from 'element-plus'
import { Edit, Delete, ArrowUp, ArrowDown } from '@element-plus/icons-vue'
import { useUserStore } from '@/stores/modules/user'

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

// 权限检查
const userStore = useUserStore()

const hasTemplateUpdatePermission = computed(() => {
  const actions = userStore.getActions
  const targetPermission = 'tickets.tickettemplates.update'
  return Array.isArray(actions) && actions.includes(targetPermission)
})

const props = defineProps<{
  fields: FieldConfig[]
  loading?: boolean
}>()

const emit = defineEmits<{
  edit: [field: FieldConfig]
  delete: [field: FieldConfig, index: number]
  moveUp: [index: number]
  moveDown: [index: number]
}>()

const emptyText = computed(() => {
  if (props.loading) return '加载中...'
  return '暂无字段配置，请添加字段'
})

const getTypeLabel = (type: string): string => {
  const typeMap: Record<string, string> = {
    text: '文本',
    textarea: '多行文本',
    number: '数字',
    select: '下拉选择',
    radio: '单选框',
    checkbox: '复选框',
    date: '日期',
    datetime: '日期时间',
    file: '文件上传',
    switch: '开关',
    department: '部门',
    position: '职位'
  }
  return typeMap[type] || type
}

const getTypeTagType = (type: string): string | undefined => {
  const typeColorMap: Record<string, string> = {
    text: 'info',
    textarea: 'info',
    number: 'warning',
    select: 'success',
    radio: 'primary',
    checkbox: 'primary',
    date: 'warning',
    datetime: 'warning',
    file: 'danger',
    switch: 'success',
    department: 'primary',
    position: 'primary'
  }
  return typeColorMap[type] || undefined
}

const getOptionsCount = (options: string): number => {
  if (!options || !options.trim()) return 0
  return options.split(',').filter(option => option.trim()).length
}

const getShowRulesCount = (showOption: string): number => {
  if (!showOption || !showOption.trim()) return 0
  try {
    // 尝试解析JSON格式的显示规则
    const rules = JSON.parse(showOption)
    return Array.isArray(rules) ? rules.length : 1
  } catch {
    // 如果不是JSON格式，按逗号分隔计算
    return showOption.split(',').filter(rule => rule.trim()).length
  }
}

const handleEdit = (field: FieldConfig) => {
  emit('edit', field)
}

const handleDelete = async (field: FieldConfig, index: number) => {
  try {
    await ElMessageBox.confirm(
      `确定要删除字段"${field.label || field.name}"吗？此操作不可恢复。`,
      '删除确认',
      {
        confirmButtonText: '确定删除',
        cancelButtonText: '取消',
        type: 'warning',
        confirmButtonClass: 'el-button--danger',
      }
    )
    emit('delete', field, index)
    ElMessage.success('字段删除成功')
  } catch (error) {
    // 用户取消删除
  }
}

const handleMoveUp = (index: number) => {
  if (index > 0) {
    emit('moveUp', index)
  }
}

const handleMoveDown = (index: number) => {
  if (index < props.fields.length - 1) {
    emit('moveDown', index)
  }
}
</script>

<style scoped>
.template-fields-table {
  width: 100%;
}

.options-count,
.rules-count {
  font-size: 12px;
  color: var(--el-color-primary);
  font-weight: 500;
}

.no-options,
.no-rules {
  color: var(--el-text-color-placeholder);
  font-style: italic;
}

:deep(.el-table) {
  border-radius: 8px;
}

:deep(.el-table th) {
  background-color: var(--el-fill-color-light);
  font-weight: 600;
}

:deep(.el-table td) {
  padding: 8px 0;
}

:deep(.el-button.is-disabled) {
  opacity: 0.4;
}
</style>
