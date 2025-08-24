<template>
  <div class="template-selector">
    <div class="selector-header">
      <h3>选择工单模板</h3>
      <el-button size="small" @click="refreshTemplates">
        <el-icon><Refresh /></el-icon>
        刷新
      </el-button>
    </div>

    <div class="search-section">
      <el-input
        v-model="searchKeyword"
        placeholder="搜索模板名称..."
        clearable
        @input="handleSearch"
      >
        <template #prefix>
          <el-icon><Search /></el-icon>
        </template>
      </el-input>
    </div>

    <div class="template-list-container" v-loading="loading">
      <div v-if="templates.length === 0 && !loading" class="empty-state">
        <el-empty :description="searchKeyword ? '未找到匹配的模板' : '暂无可用模板'" :image-size="80">
          <el-button type="primary" @click="refreshTemplates">重新加载</el-button>
        </el-empty>
      </div>

      <template v-else>
        <TemplateCard
          v-for="template in templates"
          :key="template.id"
          :template="template"
          :selected="selectedTemplate?.id === template.id"
          :user-map="userMap"
          @select="handleTemplateSelect"
        />
      </template>
    </div>

    <BasePagination 
      v-model:current-page="pagination.currentPage" 
      :page-size="pagination.pageSize"
      :total="pagination.total" 
      @page-change="handleCurrentChange" 
    />
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, watch, computed } from 'vue'
import { Refresh, Search } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'
import { debounce } from 'lodash-es'
import http from '@/support/http'
import TemplateCard from './TemplateCard.vue'
import BasePagination from '@/components/common/BasePagination.vue'

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
const searchKeyword = ref('')

// 分页数据
const pagination = ref({
  currentPage: 1,
  pageSize: 10,
  total: 0
})

// 计算属性
const selectedTemplate = computed({
  get: () => props.selectedTemplate,
  set: (value) => emit('update:selectedTemplate', value)
})

// 方法
const fetchTemplates = async () => {
  loading.value = true
  try {
    const params: any = {
      page: pagination.value.currentPage,
      limit: pagination.value.pageSize
    }
    
    // 添加搜索参数
    if (searchKeyword.value.trim()) {
      params.ticket_name = searchKeyword.value.trim()
    }
    
    const response = await http.get('tickets/app/templates', params)
    console.log('API响应:', response) // 调试日志
    if (response.data && response.data.code === 10000) {
      templates.value = response.data.data || []
      pagination.value.total = response.data.total || 0
      console.log('模板数据:', templates.value) // 调试日志
    } else {
      console.error('API响应格式错误:', response.data)
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

// 防抖搜索
const debouncedSearch = debounce(() => {
  pagination.value.currentPage = 1
  fetchTemplates()
}, 300)

// 搜索功能
const handleSearch = () => debouncedSearch()

// 分页处理
const handleCurrentChange = (page: number) => {
  if (page && page !== pagination.value.currentPage) {
    pagination.value.currentPage = page
    fetchTemplates()
  }
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

// 监听搜索关键词变化
watch(() => searchKeyword.value, () => {
  if (!searchKeyword.value) {
    handleSearch()
  }
})

// 组件挂载
onMounted(() => {
  console.log('TemplateSelector 组件挂载')
  fetchUsers()
  fetchTemplates()
})
</script>

<style scoped>
.template-selector {
  height: 100%;
  padding: 16px;
  background: var(--el-bg-color);
  border-radius: 8px;
  border: 1px solid var(--el-border-color-lighter);
  display: flex;
  flex-direction: column;
}

.selector-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
  flex-shrink: 0;
}

.selector-header h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
}

.search-section {
  margin-bottom: 16px;
  flex-shrink: 0;
}

.template-list-container {
  flex: 1 1 auto;
  min-height: 0;
  overflow-y: auto;
  overflow-x: hidden;
}

.empty-state {
  padding: 40px 20px;
  text-align: center;
}

.template-list-container::-webkit-scrollbar {
  width: 6px;
}

.template-list-container::-webkit-scrollbar-track {
  background: var(--el-border-color-lighter);
  border-radius: 3px;
}

.template-list-container::-webkit-scrollbar-thumb {
  background: var(--el-color-primary-light-3);
  border-radius: 3px;
}

.template-list-container::-webkit-scrollbar-thumb:hover {
  background: var(--el-color-primary);
}

@media (max-width: 768px) {
  .template-list-container {
    flex: 1 1 auto;
    min-height: 0;
  }
}
</style>
