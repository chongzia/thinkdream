<template>
  <div class="template-selector">
    <div class="selector-header">
      <h3>工单模板管理</h3>
      <el-space>
        <el-button size="small" @click="handleRefresh">
          <el-icon>
            <Refresh />
          </el-icon>
        </el-button>
        <el-button v-if="hasTemplateStorePermission" type="primary" size="small" @click="handleAddTemplate">
          <el-icon>
            <Plus />
          </el-icon>
          新建模板
        </el-button>
      </el-space>
    </div>

    <div class="search-section">
      <el-input v-model="searchForm.ticket_name" placeholder="搜索模板名称..." clearable @input="handleSearch"
        @keyup.enter="loadTemplates">
        <template #prefix>
          <el-icon>
            <Search />
          </el-icon>
        </template>
      </el-input>
    </div>

    <div class="template-list-container" v-loading="loading">
      <div v-if="templateList.length === 0 && !loading" class="empty-state">
        <el-empty description="暂无可用模板" :image-size="80">
          <el-button type="primary" @click="loadTemplates">重新加载</el-button>
        </el-empty>
      </div>

      <template v-else>
        <TemplateManagementCard v-for="template in templateList" :key="template.id" :template="template"
          :selected="selectedTemplateId === template.id" :user-map="userMap" @select="selectTemplate"
          @edit="editTemplate" @delete="deleteTemplate" />
      </template>
    </div>

    <BasePagination v-model:current-page="pagination.currentPage" :page-size="pagination.pageSize"
      :total="pagination.total" @page-change="handleCurrentChange" />

    <el-drawer v-model="showSaveModal" title="模板编辑" direction="ltr" size="800px" :close-on-click-modal="false"
      :close-on-press-escape="false">
      <TemplateManagementSave :template="currentEditTemplate" @close="showSaveModal = false"
        @success="handleSaveSuccess" />
    </el-drawer>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject, watch, provide, computed } from 'vue'
import { debounce } from 'lodash-es'
import { ElMessageBox, ElMessage } from 'element-plus'
import { Plus, Refresh, Search } from '@element-plus/icons-vue'
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

// 搜索表单接口
interface SearchForm {
  ticket_name: string
  ticket_is_active: string | number
}

// 分页接口
interface Pagination {
  currentPage: number
  pageSize: number
  total: number
}
import BasePagination from '@/components/common/BasePagination.vue'
import TemplateManagementCard from './TemplateManagementCard.vue'
import TemplateManagementSave from './TemplateManagementSave.vue'

// 权限检查
const userStore = useUserStore()

const hasTemplateStorePermission = computed(() => {
  const actions = userStore.getActions
  const targetPermission = 'tickets.tickettemplates.store'
  return Array.isArray(actions) && actions.includes(targetPermission)
})

const hasTemplateUpdatePermission = computed(() => {
  const actions = userStore.getActions
  const targetPermission = 'tickets.tickettemplates.update'
  return Array.isArray(actions) && actions.includes(targetPermission)
})

const hasTemplateDestroyPermission = computed(() => {
  const actions = userStore.getActions
  const targetPermission = 'tickets.tickettemplates.destroy'
  return Array.isArray(actions) && actions.includes(targetPermission)
})

const loading = ref(false)
const templateList = ref<TemplateData[]>([])
const selectedTemplateId = ref<number | null>(null)
const showSaveModal = ref(false)
const currentEditTemplate = ref<TemplateData | null>(null)
const userMap = ref<Map<number, string>>(new Map())
const userLoading = ref(false)

const searchForm = ref<SearchForm>({
  ticket_name: '',
  ticket_is_active: ''
})

const pagination = ref<Pagination>({
  currentPage: 1,
  pageSize: 10,
  total: 0
})

const onTemplateSelect = inject<(template: TemplateData | null) => void>('onTemplateSelect')

const loadTemplates = async () => {
  loading.value = true
  try {
    const params = {
      ...Object.fromEntries(
        Object.entries(searchForm.value).filter(([_, value]) => value !== undefined && value !== '')
      ),
      page: pagination.value.currentPage,
      limit: pagination.value.pageSize
    }

    const response = await http.get('tickets/ticket/templates', params)
    templateList.value = response.data?.data || []
    pagination.value.total = response.data?.total || 0
    await loadUsersBatch()

    // 如果没有选中的模板，自动选择第一个
    if (templateList.value.length > 0 && selectedTemplateId.value === null) {
      selectTemplate(templateList.value[0])
    }
  } catch (error) {
    console.error('加载模板列表失败:', error)
    ElMessage.error('加载列表失败')
  } finally {
    loading.value = false
  }
}

const loadUsersBatch = async () => {
  if (userLoading.value || templateList.value.length === 0) return

  try {
    const userIds: number[] = []

    templateList.value.forEach(template => {
      if (template.ticket_accept) {
        userIds.push(template.ticket_accept)
      }

      if (template.ticket_process) {
        const processIds = parseProcessIds(template.ticket_process)
        userIds.push(...processIds)
      }
    })

    const uniqueUserIds = [...new Set(userIds)]
    if (uniqueUserIds.length === 0) return

    userLoading.value = true
    const response = await http.get('/users/batch', { user_ids: uniqueUserIds })

    if (response.data?.data) {
      response.data.data.forEach((user: any) => {
        userMap.value.set(user.id, user.username)
      })
    }
  } catch (error) {
    console.error('批量获取用户信息失败:', error)
  } finally {
    userLoading.value = false
  }
}

const parseProcessIds = (processStr: any): number[] => {
  if (!processStr) return []

  try {
    const parsed = typeof processStr === 'string' ? JSON.parse(processStr) : processStr
    if (Array.isArray(parsed)) {
      return parsed.map(id => Number(id)).filter(id => !isNaN(id))
    }
  } catch {
    if (typeof processStr === 'string') {
      const ids = processStr.split(',').map(id => id.trim()).filter(id => id)
      return ids.map(id => Number(id)).filter(id => !isNaN(id))
    }
  }

  const id = Number(processStr)
  return !isNaN(id) ? [id] : []
}

const debouncedSearch = debounce(() => {
  pagination.value.currentPage = 1
  loadTemplates()
}, 300)

const handleSearch = () => debouncedSearch()
const handleRefresh = () => {
  pagination.value.currentPage = 1
  loadTemplates()
}

const handleAddTemplate = () => {
  currentEditTemplate.value = null
  showSaveModal.value = true
}

const editTemplate = (template: TemplateData) => {
  currentEditTemplate.value = template
  showSaveModal.value = true
}

const deleteTemplate = async (template: TemplateData) => {
  try {
    await ElMessageBox.confirm(
      `确定要删除模板"${template.ticket_name}"吗？`,
      '删除确认',
      {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }
    )

    const response = await http.delete(`tickets/ticket/templates/${template.id}`)
          if (response.data?.code === 200) {
      ElMessage.success('删除成功')

      // 如果删除的是当前选中的模板，清空选中状态
      if (selectedTemplateId.value === template.id) {
        selectedTemplateId.value = null
        onTemplateSelect?.(null as any)
      }

      // 重新加载模板列表
      if (templateList.value.length === 1 && pagination.value.currentPage > 1) {
        pagination.value.currentPage--
      }
      await loadTemplates()
    } else {
      ElMessage.error(response.data?.message || '删除失败')
    }
  } catch (error: any) {
    if (error !== 'cancel') {
      console.error('删除模板失败:', error)
      ElMessage.error('删除失败')
    }
  }
}

const selectTemplate = (template: TemplateData | null) => {
  if (template) {
    selectedTemplateId.value = template.id
    onTemplateSelect?.(template)
  } else {
    selectedTemplateId.value = null
    onTemplateSelect?.(null)
  }
}

const handleCurrentChange = (page: number) => {
  if (page && page !== pagination.value.currentPage) {
    pagination.value.currentPage = page
    loadTemplates()
  }
}

const handleSaveSuccess = () => {
  showSaveModal.value = false
  loadTemplates()
}

watch(templateList, (newList) => {
  // 如果当前选中的模板不在新列表中，清空选中状态
  if (selectedTemplateId.value !== null) {
    const templateExists = newList.some(template => template.id === selectedTemplateId.value)
    if (!templateExists) {
      selectedTemplateId.value = null
      onTemplateSelect?.(null)
    }
  }

  // 如果没有选中的模板且有可用模板，选择第一个
  if (newList.length > 0 && selectedTemplateId.value === null) {
    selectTemplate(newList[0])
  }
}, { immediate: true })

watch(() => searchForm.value.ticket_name, () => {
  if (!searchForm.value.ticket_name) {
    handleSearch()
  }
})

defineExpose({
  refreshList: loadTemplates
})

provide('userMap', userMap)

onMounted(() => {
  loadTemplates()
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
  margin-bottom: 16px;
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
