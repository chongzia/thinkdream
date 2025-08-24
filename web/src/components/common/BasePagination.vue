<template>
  <div v-if="shouldShow" class="base-pagination">
    <div class="pagination-info">
      <el-text size="small" class="info-text">
        共 {{ total }} 条，第 {{ currentPage }} / {{ totalPages }} 页
      </el-text>
    </div>
    <div class="pagination-controls">
      <el-space size="small" class="controls-space">
        <el-button 
          size="small" 
          :disabled="currentPage <= 1"
          @click="handlePageChange(currentPage - 1)"
          class="page-btn"
        >
          <el-icon><ArrowLeft /></el-icon>
        </el-button>
        <el-select 
          :model-value="currentPage"
          size="small" 
          class="page-select"
          @change="handlePageChange"
        >
          <el-option 
            v-for="page in totalPages" 
            :key="page" 
            :label="`第${page}页`" 
            :value="page" 
          />
        </el-select>
        <el-button 
          size="small" 
          :disabled="currentPage >= totalPages"
          @click="handlePageChange(currentPage + 1)"
          class="page-btn"
        >
          <el-icon><ArrowRight /></el-icon>
        </el-button>
      </el-space>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { ArrowLeft, ArrowRight } from '@element-plus/icons-vue'

// Props定义
interface Props {
  // 基础分页数据
  total: number
  currentPage?: number
  pageSize?: number
  
  // 显示控制
  autoHide?: boolean
  minTotal?: number
}

const props = withDefaults(defineProps<Props>(), {
  currentPage: 1,
  pageSize: 10,
  autoHide: true,
  minTotal: 1
})

// Emits定义
const emit = defineEmits<{
  'update:currentPage': [page: number]
  'page-change': [page: number]
}>()

// 计算属性
const currentPage = computed({
  get: () => props.currentPage,
  set: (value: number) => {
    emit('update:currentPage', value)
    emit('page-change', value)
  }
})

const totalPages = computed(() => {
  return Math.ceil(props.total / props.pageSize)
})

const shouldShow = computed(() => {
  if (!props.autoHide) return true
  return props.total >= props.minTotal
})

// 处理页码变化
const handlePageChange = (page: number) => {
  if (page && page !== currentPage.value && page >= 1 && page <= totalPages.value) {
    currentPage.value = page
  }
}
</script>

<style scoped>
.base-pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  padding: 12px 16px;
  background: var(--el-bg-color);
  border-radius: 8px;
  border: 1px solid var(--el-border-color-lighter);
  min-height: 48px;
  box-sizing: border-box;
}

.pagination-info {
  flex: 0 0 auto;
  min-width: 0;
}

.info-text {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 200px;
  display: block;
}

.pagination-controls {
  flex: 0 0 auto;
  display: flex;
  align-items: center;
}

.controls-space {
  display: flex;
  align-items: center;
  gap: 8px;
}

.page-btn {
  min-width: 32px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.page-select {
  min-width: 80px;
  max-width: 100px;
}

.page-select :deep(.el-input__wrapper) {
  padding: 0 8px;
}

.page-select :deep(.el-input__inner) {
  text-align: center;
  font-size: 13px;
}

/* 响应式设计 - 平板 */
@media (max-width: 1024px) {
  .base-pagination {
    padding: 10px 12px;
  }
  
  .info-text {
    max-width: 150px;
    font-size: 12px;
  }
  
  .page-select {
    min-width: 70px;
    max-width: 80px;
  }
}

/* 响应式设计 - 手机 */
@media (max-width: 768px) {
  .base-pagination {
    flex-direction: column;
    gap: 12px;
    align-items: stretch;
    padding: 16px;
    min-height: auto;
  }
  
  .pagination-info {
    text-align: center;
    order: 1;
  }
  
  .info-text {
    max-width: none;
    font-size: 13px;
  }
  
  .pagination-controls {
    justify-content: center;
    order: 2;
  }
  
  .controls-space {
    width: 100%;
    justify-content: center;
    gap: 12px;
  }
  
  .page-btn {
    min-width: 36px;
  }
  
  .page-select {
    min-width: 90px;
    max-width: 110px;
  }
}

/* 响应式设计 - 小屏手机 */
@media (max-width: 480px) {
  .base-pagination {
    padding: 12px;
    gap: 10px;
  }
  
  .info-text {
    font-size: 12px;
  }
  
  .controls-space {
    gap: 8px;
  }
  
  .page-btn {
    min-width: 32px;
    height: 32px;
  }
  
  .page-select {
    min-width: 80px;
    max-width: 90px;
  }
  
  .page-select :deep(.el-input__inner) {
    font-size: 12px;
  }
}

/* 超小屏手机 */
@media (max-width: 360px) {
  .base-pagination {
    padding: 10px;
  }
  
  .controls-space {
    gap: 6px;
  }
  
  .page-btn {
    min-width: 28px;
    height: 28px;
  }
  
  .page-select {
    min-width: 70px;
    max-width: 80px;
  }
}

/* 横屏模式 */
@media (max-height: 500px) and (orientation: landscape) {
  .base-pagination {
    flex-direction: row;
    gap: 16px;
    align-items: center;
    padding: 8px 12px;
  }
  
  .pagination-info {
    order: 0;
    text-align: left;
  }
  
  .pagination-controls {
    order: 0;
  }
}

/* 打印样式 */
@media print {
  .base-pagination {
    display: none;
  }
}

/* 深色主题适配 */
@media (prefers-color-scheme: dark) {
  .base-pagination {
    background: var(--el-bg-color-overlay);
    border-color: var(--el-border-color);
  }
}

/* 高对比度模式 */
@media (prefers-contrast: high) {
  .base-pagination {
    border-width: 2px;
  }
  
  .page-btn {
    border-width: 2px;
  }
}

/* 减少动画模式 */
@media (prefers-reduced-motion: reduce) {
  .base-pagination * {
    transition: none !important;
    animation: none !important;
  }
}
</style>
