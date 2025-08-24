<template>
  <div class="flex bg-gray-50">
    <!-- Sidebar using Element Plus Tabs -->
    <!-- Sidebar using Element Plus Tabs -->
    <div class="flex flex-col w-64 border-r border-gray-200 ai-service-tabs-container">
      <el-tabs v-model="activeTab" tab-position="left" class="flex-1 ai-service-tabs" @tab-change="handleTabChange" v-if="providers.length > 0">
        <el-tab-pane v-for="(item, index) in providers" :key="index" :name="item.title">
          <template #label>
            <div class="flex items-center justify-between w-full py-2 gap-y-2">
              <div class="flex">
                <img :src="item.logo" :alt="item.title" class="w-5 h-5 mr-3" />
                <span class="flex-grow text-gray-900 text-md">{{ item.title.substring(0, 15) }}...</span>
              </div>
              <div :class="['w-1.5 h-1.5 rounded-full', item.status === 1 ? 'bg-green-500' : 'bg-gray-300']"></div>
            </div>
          </template>
        </el-tab-pane>
      </el-tabs>
      <!-- 添加厂商按钮 -->
      <div class="p-4 border-t border-gray-200">
        <el-button type="primary" class="w-full" @click="handleAddPrivoder">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          添加服务商
        </el-button>
      </div>
    </div>
    <!-- Main Content -->
    <main class="flex-1 px-8 pb-8 bg-white">
      <div class="max-w-3xl">
        <!-- Header -->
        <div class="flex items-center justify-between h-28">
          <div class="flex items-center">
            <Upload v-model="provider.logo" className="w-6 h-6 mr-2" />
            <el-input v-model="provider.title" placeholder="请输入服务商名称" v-if="editTitle" />
            <h1 class="text-xl font-semibold" @click="handleEditTitle" v-else>{{ provider.title }}</h1>
          </div>
          <el-switch v-model="provider.status" :inactive-value="2" :active-value="1" @change="closeProvider" />
        </div>

        <!-- Form -->
        <div class="mt-10 space-y-6">
          <!-- API Key -->
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">API Key</label>
            <div class="flex items-center gap-2">
              <el-input v-model="provider.api_key" placeholder="请输入 API Key" class="flex-1" />
              <el-link type="primary" class="text-sm">设置指引</el-link>
            </div>
          </div>

          <!-- Service URL -->
          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">服务地址</label>
            <el-input v-model="provider.api_url" placeholder="API 服务地址" />
          </div>

          <!-- Connection Test -->
          <!--<div>
            <label class="block mb-1 text-sm font-medium text-gray-700">连通性检查</label>
            <el-button>检查</el-button>
          </div>-->

          <!-- Model Selection -->
          <div v-if="provider.models.length > 0">
            <label class="block mb-3 text-sm font-medium text-gray-700">模型列表</label>
            <div class="flex flex-col gap-y-2">
              <div v-for="model in provider.models" :key="model.id" class="flex items-center justify-between w-full py-2 bg-gray-100 rounded">
                <div class="flex items-center gap-2">
                  <span class="px-3 text-sm text-gray-600 border-r border-solid">{{ model.display_name }}</span>
                  <span class="px-2 text-xs text-gray-500 border-r border-solid">{{ model.name }}</span>
                  <span class="px-2 text-xs text-gray-500 border-r border-solid">{{ model.max_token }}K</span>
                  <span class="flex items-center px-2 text-xs text-gray-500" v-if="model.is_support_image === 1">
                    <el-tooltip effect="dark" content="支持图像" placement="top-start">
                      <el-icon><Picture /></el-icon>
                    </el-tooltip>
                  </span>
                </div>
                <!--操作-->
                <div class="flex items-center px-4">
                  <div>
                    <el-switch v-model="model.status" :inactive-value="2" :active-value="1" @change="closeModel(model.id)" size="small" />
                  </div>
                  <div class="flex items-center px-4 gap-x-2">
                    <el-tooltip effect="dark" content="修改模型" placement="top-start">
                      <el-icon class="cursor-pointer" @click="handleEditModel(model.id)"><Setting class="text-sm text-gray-500" /></el-icon>
                    </el-tooltip>
                    <el-icon class="cursor-pointer"><Delete class="text-sm text-gray-500" @click="handleDeleteModel(model.id)" /></el-icon>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-between w-full gap-3">
            <div>
              <el-button @click="handleAddModel" type="primary" size="small">
                <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg
                >新增模型</el-button
              >
            </div>
            <div>
              <el-button @click="handleSaveProvider" size="small">保 存</el-button>
              <el-button @click="handleDeleteProvider" type="danger" size="small">删 除</el-button>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!--添加 AI 厂商-->
    <Dialog v-model="addProviderVisible" title="添加服务商" destroy-on-close>
      <CreateProvider api="ai/providers" @close="closeAddPrivoder" />
    </Dialog>

    <!--添加模型-->
    <Dialog v-model="addModelVisible" :title="handleModelTitle" destroy-on-close>
      <CreateModel api="ai/provider/models" @close="closeAddModel" :providerId="provider.id" :primary="modelId" />
    </Dialog>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import CreateProvider from './createProvider.vue'
import CreateModel from './createModel.vue'
import http from '@/support/http'
import { useDestroy } from '@/composables/curd/useDestroy'
import Message from '@/support/message'
import { Setting, Delete, Picture } from '@element-plus/icons-vue'
const activeTab = ref('')
const addProviderVisible = ref(false)
const providers = ref<ProviderInterface[]>([])
const addModelVisible = ref(false)
const modelId = ref<number | string>('')
const editTitle = ref(false)
const { destroy, deleted } = useDestroy()
const handleModelTitle = ref('添加新模型')
interface ModelInterface {
  id: number
  name: string
  provider_id: number
  display_name: string
  max_token: number
  is_support_image: number
  status: number
}
interface ProviderInterface {
  id: number | string
  title: string
  logo: string
  api_key: string
  api_url: string
  status: number
  models: ModelInterface[]
}

const providerInstance = {
  id: 0,
  title: '',
  logo: '',
  api_key: '',
  api_url: '',
  status: 1,
  models: []
}
const provider = ref<ProviderInterface>(providerInstance)

// 添加 provider
const handleAddPrivoder = () => {
  addProviderVisible.value = true
}
// 保存 provider
const handleSaveProvider = () => {
  if (!provider.value.id) {
    return
  }
  http.put('/ai/providers/' + provider.value.id, provider.value).then(r => {
    Message.success('保存成功')
    editTitle.value = false
    getAiProviders()
  })
}
const handleEditTitle = () => {
  editTitle.value = !editTitle.value
}
// 删除 provider
const handleDeleteProvider = () => {
  deleted(() => {
    activeTab.value = ''
    getAiProviders()
  })
  if (provider.value.id) {
    destroy('ai/providers', provider.value.id)
  }
}
// 关闭 provider 添加
const closeAddPrivoder = () => {
  addProviderVisible.value = false
  activeTab.value = ''
  console.log(activeTab.value)
  getAiProviders()
}

// 添加模型
const handleAddModel = () => {
  handleModelTitle.value = '添加新模型'

  modelId.value = ''
  addModelVisible.value = true
}
// 关闭模型添加
const closeAddModel = () => {
  addModelVisible.value = false
  getAiProviders()
}

const handleEditModel = (id: number) => {
  handleModelTitle.value = '修改模型'
  modelId.value = id
  addModelVisible.value = true
}

const handleDeleteModel = (id: number) => {
  deleted(() => {
    getAiProviders()
  })
  destroy('ai/provider/models', id)
}
/**
 * 处理 tab 切换
 *
 * @param item
 */
const handleTabChange = (name: string) => {
  getProviderByName(name)
}

const getProviderByName = (name: string) => {
  providers.value.forEach((item: any) => {
    if (item.title === name) {
      provider.value = item
    }
  })
}
// 获取AI服务商
const getAiProviders = () => {
  http.get('ai/providers').then(r => {
    providers.value = r.data.data
    if (providers.value.length > 0) {
      if (!activeTab.value) {
        provider.value = providers.value[0]
        activeTab.value = provider.value.title
      } else {
        getProviderByName(activeTab.value)
      }
    } else {
      provider.value = providerInstance
    }
  })
}

const closeProvider = (value: any) => {
  http.put('/ai/providers/enable/' + provider.value.id).then(r => {
    getAiProviders()
  })
}

const closeModel = (id: any) => {
  http.put('/ai/provider/models/enable/' + id).then(r => {
    Message.success('操作成功')
    getAiProviders()
  })
}
getAiProviders()
</script>

<style>
/* 添加新的容器样式 */
.ai-service-tabs-container {
  background-color: rgb(249, 250, 251);
  display: flex;
  flex-direction: column;
}
.el-tabs__content {
  display: none !important;
}
.ai-service-tabs {
  /* 移除默认边框和阴影 */
  --el-tabs-header-height: auto;
  background-color: rgb(249, 250, 251);
}
.el-tabs--left {
  flex-direction: none !important;
  padding: 10px;
}
.el-tabs--left .el-tabs__header.is-left {
  width: 100% !important;
}
.ai-service-tabs .el-tabs__nav-wrap.is-left {
  width: 100% !important;
}
/* 调整整体tab容器的样式 */
.ai-service-tabs .el-tabs__nav {
  width: 100%;
}

/* 移除 tab 下的蓝色线条 */
.ai-service-tabs .el-tabs__active-bar {
  display: none;
}

/* 移除 tab 的默认边框 */
.ai-service-tabs .el-tabs__nav-wrap::after {
  display: none;
}

/* 调整每个tab项的样式 */
.ai-service-tabs .el-tabs__item {
  height: auto !important;
  text-align: left !important;
  padding: 8px 16px !important;
  border-radius: 8px;
  transition: all 0.3s ease;
  line-height: 1.5;
}

/* 未选中tab的样式 */
.ai-service-tabs .el-tabs__item:not(.is-active):hover {
  background-color: #f3f4f6;
  color: var(--el-text-color-primary);
}

/* 选中的tab样式 */
.ai-service-tabs .el-tabs__item.is-active {
  background-color: #f3f4f6;
  color: var(--el-text-color-primary);
}

/* 移除tab项focus时的样式 */
.ai-service-tabs .el-tabs__item:focus.is-active.is-focus:not(:active) {
  box-shadow: none;
}

/* 调整tab内容的布局 */
.ai-service-tabs .el-tabs__content {
  padding: 0;
}

/* 移除tab项的边框 */
.ai-service-tabs .el-tabs__nav-wrap.is-left {
  margin-right: 0;
}

/* 调整tab容器的内边距 */
.ai-service-tabs .el-tabs__nav-scroll {
  padding: 8px 0;
}

/* 确保内容区域不会溢出 */
.ai-service-tabs .el-tabs__content {
  overflow: visible;
}

/* 移除tab项的默认边框和焦点样式 */
.ai-service-tabs .el-tabs__item {
  border: none !important;
}

/* 调整激活状态下的文字颜色 */
.ai-service-tabs .el-tabs__item.is-active {
  color: var(--el-text-color-primary) !important;
}
</style>
