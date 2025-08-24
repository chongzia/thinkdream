<template>
  <div v-loading="loading">
    <div v-if="parsedFormData" class="form-data-viewer">
      <el-card class="data-summary">
        <template #header>
          <div class="card-header">
            <span>表单数据概览</span>
            <el-tag type="info">共 {{ dataKeys.length }} 个字段</el-tag>
          </div>
        </template>
        
        <div class="data-display">
          <!-- 以表格形式展示表单数据 -->
          <el-table :data="formattedData" border stripe>
            <el-table-column prop="field" label="字段名" width="200" />
            <el-table-column prop="label" label="字段标签" width="180" />
            <el-table-column prop="value" label="填写内容" show-overflow-tooltip>
              <template #default="scope">
                <div v-if="scope.row.type === 'image'">
                  <el-image 
                    :src="scope.row.value" 
                    style="width: 60px; height: 60px;"
                    :preview-src-list="[scope.row.value]"
                    fit="cover"
                    v-if="scope.row.value"
                  />
                  <span v-else>无图片</span>
                </div>
                <div v-else-if="scope.row.type === 'file'">
                  <el-link 
                    :href="scope.row.value" 
                    target="_blank" 
                    type="primary"
                    v-if="scope.row.value"
                  >
                    <el-icon><Document /></el-icon>
                    查看文件
                  </el-link>
                  <span v-else>无文件</span>
                </div>
                <div v-else-if="scope.row.type === 'array'">
                  <el-tag 
                    v-for="(item, index) in scope.row.value" 
                    :key="index"
                    class="mr-1 mb-1"
                  >
                    {{ item }}
                  </el-tag>
                </div>
                <div v-else>
                  {{ scope.row.displayValue }}
                </div>
              </template>
            </el-table-column>
            <el-table-column prop="type" label="字段类型" width="120">
              <template #default="scope">
                <el-tag :type="getTypeTagType(scope.row.type)" size="small">
                  {{ getTypeDisplayName(scope.row.type) }}
                </el-tag>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </el-card>

      <!-- 原始JSON数据展示 -->
      <el-card class="raw-data mt-4">
        <template #header>
          <div class="card-header">
            <span>原始JSON数据</span>
            <el-button size="small" @click="copyToClipboard">
              <el-icon><CopyDocument /></el-icon>
              复制
            </el-button>
          </div>
        </template>
        <el-input
          v-model="formattedJson"
          type="textarea"
          :rows="10"
          readonly
          placeholder="JSON数据"
        />
      </el-card>
    </div>

    <el-empty v-else-if="!loading" description="暂无表单数据" />
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, computed } from 'vue'
import { Document, CopyDocument } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'

interface Props {
  formData: string
  templateId?: number
}

const props = defineProps<Props>()

const loading = ref(false)

// 解析表单数据
const parsedFormData = computed(() => {
  if (!props.formData) return null
  
  try {
    return typeof props.formData === 'string' 
      ? JSON.parse(props.formData)
      : props.formData
  } catch (error) {
    console.error('解析表单数据失败:', error)
    return null
  }
})

// 获取数据键列表
const dataKeys = computed(() => {
  return parsedFormData.value ? Object.keys(parsedFormData.value) : []
})

// 格式化JSON用于显示
const formattedJson = computed(() => {
  return parsedFormData.value ? JSON.stringify(parsedFormData.value, null, 2) : ''
})

// 格式化数据用于表格显示
const formattedData = computed(() => {
  if (!parsedFormData.value) return []
  
  return dataKeys.value.map(key => {
    const value = parsedFormData.value[key]
    const type = getFieldType(value)
    
    return {
      field: key,
      label: getFieldLabel(key),
      value: value,
      displayValue: getDisplayValue(value, type),
      type: type
    }
  })
})

// 获取字段类型
const getFieldType = (value: any): string => {
  if (value === null || value === undefined) return 'empty'
  if (Array.isArray(value)) return 'array'
  if (typeof value === 'boolean') return 'boolean'
  if (typeof value === 'number') return 'number'
  if (typeof value === 'string') {
    // 判断是否为图片URL
    if (/\.(jpg|jpeg|png|gif|webp)$/i.test(value)) return 'image'
    // 判断是否为文件URL
    if (/\.(pdf|doc|docx|xls|xlsx|zip|rar)$/i.test(value)) return 'file'
    // 判断是否为URL
    if (/^https?:\/\//.test(value)) return 'url'
    return 'text'
  }
  if (typeof value === 'object') return 'object'
  return 'unknown'
}

// 获取字段标签
const getFieldLabel = (key: string): string => {
  // 这里可以根据模板配置或者约定转换字段名
  const labelMap: Record<string, string> = {
    'name': '姓名',
    'phone': '电话',
    'email': '邮箱',
    'company': '公司',
    'department': '部门',
    'title': '标题',
    'description': '描述',
    'priority': '优先级',
    'category': '分类',
    'attachment': '附件'
  }
  
  return labelMap[key] || key
}

// 获取显示值
const getDisplayValue = (value: any, type: string): string => {
  if (value === null || value === undefined) return '-'
  if (type === 'array') return `[${value.length}个项目]`
  if (type === 'object') return '[对象]'
  if (type === 'boolean') return value ? '是' : '否'
  return String(value)
}

// 获取类型标签颜色
const getTypeTagType = (type: string): string => {
  const typeColors: Record<string, string> = {
    'text': 'primary',
    'number': 'success',
    'boolean': 'warning',
    'array': 'info',
    'object': 'danger',
    'image': 'success',
    'file': 'warning',
    'url': 'primary',
    'empty': ''
  }
  return typeColors[type] || ''
}

// 获取类型显示名称
const getTypeDisplayName = (type: string): string => {
  const typeNames: Record<string, string> = {
    'text': '文本',
    'number': '数字',
    'boolean': '布尔',
    'array': '数组',
    'object': '对象',
    'image': '图片',
    'file': '文件',
    'url': '链接',
    'empty': '空值'
  }
  return typeNames[type] || type
}

// 复制到剪贴板
const copyToClipboard = async () => {
  try {
    await navigator.clipboard.writeText(formattedJson.value)
    ElMessage.success('已复制到剪贴板')
  } catch (error) {
    console.error('复制失败:', error)
    ElMessage.error('复制失败')
  }
}
</script>

<style scoped>
.form-data-viewer {
  max-height: 70vh;
  overflow-y: auto;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.data-display {
  max-height: 50vh;
  overflow-y: auto;
}

.mr-1 {
  margin-right: 4px;
}

.mb-1 {
  margin-bottom: 4px;
}
</style>
