<template>
  <div class="template-selector">
    <el-card class="selector-card">
      <template #header>
        <div class="card-header">
          <span>选择工单模板</span>
          <el-button size="small" @click="refreshTemplates">
            <el-icon><Refresh /></el-icon>
            刷新
          </el-button>
        </div>
      </template>
      
      <div class="template-list">
        <div v-loading="loading" class="loading-container">
          <template v-if="templates.length > 0">
            <TemplateCard
              v-for="template in templates"
              :key="template.id"
              :template="template"
              :selected="selectedTemplate?.id === template.id"
              :user-map="userMap"
              @select="handleTemplateSelect"
            />
          </template>
          
          <el-empty v-else-if="!loading" description="暂无可用模板" />
        </div>
      </div>
    </el-card>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, watch } from 'vue'
import { Refresh } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'
import http from '@/support/http'
import TemplateCard from './TemplateCard.vue'

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
  created_at: string
  updated_at: string
}

// Props
interface Props {
  selectedTemplate?: TemplateData | null
}

const props = withDefaults(defineProps<Props>(), {
  selectedTemplate: null
})

// Emits
const emit = defineEmits<{
  'update:selectedTemplate': [template: TemplateData | null]
  'templateSelect': [template: TemplateData]
}>()

// 响应式数据
const loading = ref(false)
const templates = ref<TemplateData[]>([])
const userMap = ref<Map<number, string>>(new Map())

// 计算属性
const selectedTemplate = computed({
  get: () => props.selectedTemplate,
  set: (value) => emit('update:selectedTemplate', value)
})

// 方法
const fetchTemplates = async () => {
  loading.value = true
  try {
    const response = await http.get('tickets/app/templates')
    if (response.data && response.data.code === 200) {
      templates.value = response.data.data || []
    } else {
      ElMessage.error('获取模板列表失败')
    }
  } catch (error) {
    console.error('获取模板列表失败:', error)
    ElMessage.error('获取模板列表失败')
  } finally {
    loading.value = false
  }
}

const fetchUsers = async () => {
  try {
    const response = await http.get('/users')
    if (response.data && response.data.data) {
      const users = response.data.data
      users.forEach((user: any) => {
        userMap.value.set(user.id, user.username)
      })
    }
  } catch (error) {
    console.error('获取用户列表失败:', error)
  }
}

const handleTemplateSelect = (template: TemplateData) => {
  selectedTemplate.value = template
  emit('templateSelect', template)
}

const refreshTemplates = () => {
  fetchTemplates()
}

// 暴露方法给父组件
defineExpose({
  refreshTemplates
})

// 监听器
watch(() => props.selectedTemplate, (newVal) => {
  if (!newVal) {
    selectedTemplate.value = null
  }
})

// 组件挂载
onMounted(() => {
  fetchUsers()
  fetchTemplates()
})
</script>

<style scoped>
.template-selector {
  height: 100%;
}

.selector-card {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
}

.template-list {
  flex: 1;
  overflow-y: auto;
  padding: 8px 0;
}

.loading-container {
  min-height: 200px;
}

/* 滚动条样式 */
.template-list::-webkit-scrollbar {
  width: 6px;
}

.template-list::-webkit-scrollbar-track {
  background: var(--el-border-color-lighter);
  border-radius: 3px;
}

.template-list::-webkit-scrollbar-thumb {
  background: var(--el-color-primary-light-3);
  border-radius: 3px;
}

.template-list::-webkit-scrollbar-thumb:hover {
  background: var(--el-color-primary);
}

/* 响应式设计 */
@media (max-width: 768px) {
  .template-list {
    padding: 4px 0;
  }
}
</style>
