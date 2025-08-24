<template>
  <div 
    class="base-card-wrapper" 
    :class="{ 
      'selected': selected,
      'clickable': clickable,
      [`size-${size}`]: true
    }"
    @click="handleClick"
  >
    <el-card 
      :shadow="shadow" 
      class="base-card"
      :body-style="cardBodyStyle"
      :header-class="headerClass"
      :body-class="bodyClass"
    >
      <!-- 左上角标 -->
      <el-tag 
        v-if="leftTopBadge"
        :type="leftTopBadge.type || 'primary'"
        :size="leftTopBadge.size || 'small'"
        class="corner-badge left-top-badge"
      >
        {{ leftTopBadge.text }}
      </el-tag>
      
      <!-- 右上角标 -->
      <el-tag 
        v-if="rightTopBadge"
        :type="rightTopBadge.type || 'info'"
        :size="rightTopBadge.size || 'small'"
        class="corner-badge right-top-badge"
      >
        {{ rightTopBadge.text }}
      </el-tag>
      
      <!-- 左下角标 -->
      <el-tag 
        v-if="leftBottomBadge"
        :type="leftBottomBadge.type || 'info'"
        :size="leftBottomBadge.size || 'small'"
        class="corner-badge left-bottom-badge"
      >
        {{ leftBottomBadge.text }}
      </el-tag>
      
      <!-- 右下角标 -->
      <el-tag 
        v-if="rightBottomBadge"
        :type="rightBottomBadge.type || 'info'"
        :size="rightBottomBadge.size || 'small'"
        class="corner-badge right-bottom-badge"
      >
        {{ rightBottomBadge.text }}
      </el-tag>

      <!-- 卡片头部 -->
      <template #header v-if="$slots.header || title">
        <div class="card-header">
          <slot name="header">
            <div class="title-section">
              <h4 class="card-title">{{ title }}</h4>
              <slot name="title-extra"></slot>
            </div>
          </slot>
          
          <!-- 选中状态图标 -->
          <el-icon v-if="selected && showSelectedIcon" class="selected-icon" color="var(--el-color-primary)">
            <CircleCheck />
          </el-icon>
          
          <!-- 头部操作区域 -->
          <div v-if="$slots['header-actions']" class="header-actions">
            <slot name="header-actions"></slot>
          </div>
        </div>
      </template>

      <!-- 卡片主体内容 -->
      <div class="card-content">
        <!-- 描述区域 -->
        <div v-if="$slots.description || description" class="description-section">
          <slot name="description">
            <p class="card-description">{{ description }}</p>
          </slot>
        </div>

        <!-- 主要内容区域 -->
        <div class="main-content">
          <slot></slot>
        </div>

        <!-- 信息区域 -->
        <div v-if="$slots.info" class="info-section">
          <slot name="info"></slot>
        </div>
      </div>

      <!-- 卡片底部 -->
      <template #footer v-if="$slots.footer || $slots.actions">
        <div class="card-footer">
          <slot name="footer">
            <div v-if="$slots.actions" class="actions-section">
              <slot name="actions"></slot>
            </div>
          </slot>
        </div>
      </template>
    </el-card>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { CircleCheck } from '@element-plus/icons-vue'

// 角标类型定义
interface BadgeConfig {
  text: string
  type?: 'primary' | 'success' | 'warning' | 'danger' | 'info'
  size?: 'large' | 'default' | 'small'
}

// Props定义
interface Props {
  // 基础属性
  title?: string
  description?: string
  selected?: boolean
  clickable?: boolean
  showSelectedIcon?: boolean
  
  // 卡片样式
  shadow?: 'always' | 'hover' | 'never'
  size?: 'small' | 'medium' | 'large'
  
  // 自定义样式类
  headerClass?: string
  bodyClass?: string
  
  // 角标配置
  leftTopBadge?: BadgeConfig
  rightTopBadge?: BadgeConfig
  leftBottomBadge?: BadgeConfig
  rightBottomBadge?: BadgeConfig
}

const props = withDefaults(defineProps<Props>(), {
  selected: false,
  clickable: true,
  showSelectedIcon: true,
  shadow: 'hover',
  size: 'medium'
})

// Emits定义
const emit = defineEmits<{
  click: []
}>()

// 计算属性
const cardBodyStyle = computed(() => {
  const baseStyle = {
    position: 'relative' as const,
    padding: props.size === 'small' ? '12px' : props.size === 'large' ? '20px' : '16px'
  }
  return baseStyle
})

// 事件处理
const handleClick = () => {
  if (props.clickable) {
    emit('click')
  }
}
</script>

<style scoped>
.base-card-wrapper {
  margin-bottom: 12px;
  transition: all 0.3s ease;
  position: relative;
}

.base-card-wrapper.clickable {
  cursor: pointer;
}

.base-card-wrapper.clickable:hover .base-card {
  transform: translateY(-2px);
  border: 1px solid var(--el-color-primary);
  box-shadow: none;
}

.base-card-wrapper.selected .base-card {
  border: 2px solid var(--el-color-primary);
  box-shadow: 0 4px 12px rgba(64, 158, 255, 0.2);
}

.base-card {
  border-radius: 10px !important;
  transition: all 0.3s ease;
  position: relative;
  overflow: visible;
}

/* 尺寸变体 */
.size-small .base-card {
  border-radius: 8px !important;
}

.size-large .base-card {
  border-radius: 20px !important;
}

/* 角标样式 */
.corner-badge {
  position: absolute;
  z-index: 10;
  font-weight: 600;
  font-size: 11px;
  padding: 4px 8px;
}

.left-top-badge {
  top: 0;
  left: 0;
  border-radius: 0 16px 16px 0;
}

.right-top-badge {
  top: 0;
  right: 0;
  border-radius: 16px 0 0 16px;
}

.left-bottom-badge {
  bottom: 0;
  left: 0;
  border-radius: 0 16px 16px 0;
}

.right-bottom-badge {
  bottom: 0;
  right: 0;
  border-radius: 16px 0 0 16px;
}

/* 卡片头部 */
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 12px;
}

.title-section {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 8px;
}

.card-title {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
  color: var(--el-text-color-primary);
  line-height: 1.4;
}

.size-small .card-title {
  font-size: 14px;
}

.size-large .card-title {
  font-size: 18px;
}

.selected-icon {
  font-size: 20px;
  flex-shrink: 0;
}

.header-actions {
  flex-shrink: 0;
}

/* 卡片内容 */
.card-content {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.description-section {
  margin: 0;
}

.card-description {
  margin: 0;
  font-size: 13px;
  color: var(--el-text-color-secondary);
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.main-content {
  flex: 1;
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

/* Element UI Card Footer 样式覆盖 */
:deep(.el-card__footer) {
  padding: 8px !important;
}

/* 卡片底部 */
.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 0px;
  margin-top: 0px;
  padding: 6px 16px;
  height: 25px !important;
}

.actions-section {
  display: flex;
  gap: 6px;
  margin-left: auto;
}

/* 响应式设计 */
@media (max-width: 768px) {
  .base-card-wrapper {
    margin-bottom: 8px;
  }
  
  .card-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .title-section {
    width: 100%;
  }
  
  .card-title {
    font-size: 14px;
  }
  
  .actions-section {
    margin-left: 0;
    justify-content: flex-end;
    width: 100%;
  }
}

/* 深色主题适配 */
@media (prefers-color-scheme: dark) {
  .base-card-wrapper.selected .base-card {
    box-shadow: 0 4px 12px rgba(64, 158, 255, 0.3);
  }
}

/* 打印样式 */
@media print {
  .base-card-wrapper {
    break-inside: avoid;
    margin-bottom: 8px;
  }
  
  .base-card-wrapper:hover {
    transform: none;
  }
  
  .corner-badge {
    display: none;
  }
}
</style>
