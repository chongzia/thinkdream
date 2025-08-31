<template>
  <div class="form-data-viewer">
    <el-alert
      title="用户提交的表单数据"
      type="info"
      :closable="false"
      class="mb-4"
    />

    <div v-if="formDataArray.length > 0" class="data-grid">
      <div 
        v-for="item in formDataArray" 
        :key="item.key"
        class="data-item"
      >
        <div class="data-header">
          <span class="data-label">{{ item.label }}</span>
          <el-tag v-if="item.required" type="danger" size="small">必填</el-tag>
        </div>
        
        <div class="data-content">
          <div class="data-value">
            <!-- 处理不同类型的值 -->
            <template v-if="item.type === 'array'">
              <div class="array-values">
                <el-tag 
                  v-for="(arrayItem, index) in item.value" 
                  :key="index"
                  class="array-item"
                  type="primary"
                >
                  {{ arrayItem }}
                </el-tag>
              </div>
            </template>
            
            <template v-else-if="item.type === 'boolean'">
              <el-tag :type="item.value ? 'success' : 'danger'">
                {{ item.value ? '是' : '否' }}
              </el-tag>
            </template>
            
            <template v-else-if="item.type === 'date'">
              <el-tag type="info">
                <el-icon><Calendar /></el-icon>
                {{ formatDate(item.value) }}
              </el-tag>
            </template>
            
            <template v-else-if="item.type === 'number'">
              <el-tag type="warning">
                <el-icon><EditPen /></el-icon>
                {{ item.value }}
              </el-tag>
            </template>
            
            <template v-else-if="item.type === 'url'">
              <el-link :href="item.value" target="_blank" type="primary">
                {{ item.value }}
              </el-link>
            </template>
            
            <template v-else-if="item.type === 'email'">
              <el-link :href="'mailto:' + item.value" type="primary">
                <el-icon><Message /></el-icon>
                {{ item.value }}
              </el-link>
            </template>
            
            <template v-else-if="item.type === 'phone'">
              <el-link :href="'tel:' + item.value" type="primary">
                <el-icon><Phone /></el-icon>
                {{ item.value }}
              </el-link>
            </template>
            
            <template v-else>
              <!-- 普通文本 -->
              <div class="text-value" :class="{ 'long-text': isLongText(item.value) }">
                <span v-if="!isLongText(item.value)">{{ item.value }}</span>
                <div v-else class="expandable-text">
                  <div 
                    class="text-content" 
                    :class="{ 'expanded': item.expanded }"
                  >
                    {{ item.value }}
                  </div>
                  <el-button 
                    type="text" 
                    size="small" 
                    @click="toggleExpand(item)"
                    class="expand-btn"
                  >
                    {{ item.expanded ? '收起' : '展开' }}
                  </el-button>
                </div>
              </div>
            </template>
          </div>
          
          <!-- 字段描述或说明 -->
          <div v-if="item.description" class="data-description">
            <el-icon><InfoFilled /></el-icon>
            {{ item.description }}
          </div>
        </div>
      </div>
    </div>

    <el-empty v-else description="没有提交数据" />
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { Calendar, EditPen, Message, Phone, InfoFilled } from '@element-plus/icons-vue'

interface FormField {
  name: string
  label: string
  type: string
  required?: boolean
  description?: string
}

interface Props {
  formData: Record<string, any>
  templateFields?: FormField[]
}

const props = withDefaults(defineProps<Props>(), {
  templateFields: () => []
})

// 计算属性
const formDataArray = computed(() => {
  const result: any[] = []
  
  Object.entries(props.formData).forEach(([key, value]) => {
    const field = props.templateFields.find(f => f.name === key)
    
    const item = {
      key,
      label: field?.label || formatFieldName(key),
      value: value,
      type: detectValueType(value, key),
      required: field?.required || false,
      description: field?.description,
      expanded: false
    }
    
    result.push(item)
  })
  
  return result.sort((a, b) => {
    // 必填字段优先显示
    if (a.required !== b.required) {
      return a.required ? -1 : 1
    }
    return a.label.localeCompare(b.label, 'zh-CN')
  })
})

// 方法
const formatFieldName = (fieldName: string): string => {
  // 将字段名转换为更友好的显示名称
  const nameMap: Record<string, string> = {
    'name': '姓名',
    'phone': '电话',
    'email': '邮箱',
    'company': '公司',
    'department': '部门',
    'position': '职位',
    'title': '标题',
    'description': '描述',
    'content': '内容',
    'priority': '优先级',
    'category': '分类',
    'attachment': '附件',
    'remark': '备注',
    'address': '地址',
    'birthday': '生日',
    'gender': '性别'
  }
  
  return nameMap[fieldName] || fieldName
}

const detectValueType = (value: any, key: string): string => {
  if (Array.isArray(value)) return 'array'
  if (typeof value === 'boolean') return 'boolean'
  if (typeof value === 'number') return 'number'
  
  if (typeof value === 'string') {
    // 检测特殊类型
    if (/^\d{4}-\d{2}-\d{2}/.test(value)) return 'date'
    if (/^https?:\/\//.test(value)) return 'url'
    if (/^[\w.-]+@[\w.-]+\.\w+$/.test(value)) return 'email'
    if (/^1[3-9]\d{9}$/.test(value)) return 'phone'
  }
  
  return 'text'
}

const isLongText = (value: any): boolean => {
  return typeof value === 'string' && value.length > 100
}

const toggleExpand = (item: any) => {
  item.expanded = !item.expanded
}

const formatDate = (dateStr: string): string => {
  try {
    const date = new Date(dateStr)
    return date.toLocaleDateString('zh-CN')
  } catch {
    return dateStr
  }
}
</script>

<style scoped>
.form-data-viewer {
  padding: 0;
}

.mb-4 {
  margin-bottom: 16px;
}

.data-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 16px;
}

.data-item {
  border: 1px solid var(--el-border-color-light);
  border-radius: 8px;
  padding: 16px;
  background-color: var(--el-bg-color);
  transition: all 0.3s ease;
}

.data-item:hover {
  border-color: var(--el-color-primary-light-5);
  box-shadow: 0 2px 8px var(--el-color-primary-light-9);
}

.data-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.data-label {
  font-weight: 600;
  color: var(--el-text-color-primary);
  font-size: 14px;
}

.data-content {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.data-value {
  flex: 1;
}

.array-values {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

.array-item {
  font-size: 12px;
}

.text-value {
  color: var(--el-text-color-regular);
  line-height: 1.6;
}

.long-text .expandable-text {
  position: relative;
}

.text-content {
  word-break: break-word;
  max-height: 60px;
  overflow: hidden;
  transition: max-height 0.3s ease;
}

.text-content.expanded {
  max-height: none;
}

.expand-btn {
  margin-top: 4px;
  padding: 0;
  font-size: 12px;
}

.data-description {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: var(--el-text-color-placeholder);
  font-style: italic;
}

/* 空状态样式 */
.el-empty {
  padding: 40px 20px;
}
</style>