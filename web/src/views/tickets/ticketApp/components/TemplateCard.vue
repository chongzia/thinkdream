<template>
  <div 
    class="template-card" 
    :class="{ 'selected': selected }"
    @click="handleSelect"
  >
    <div class="card-content">
      <div class="card-header">
        <h4 class="template-name">{{ template.ticket_name }}</h4>
        <el-tag 
          :type="template.ticket_is_active === 1 ? 'success' : 'warning'" 
          size="small"
        >
          {{ template.ticket_is_active === 1 ? '已启用' : '已禁用' }}
        </el-tag>
      </div>
      
      <div class="template-description">
        {{ template.ticket_description || '暂无描述' }}
      </div>
      
      <div class="template-info">
        <div class="info-item">
          <el-icon size="14">
            <User />
          </el-icon>
          <span class="info-label">受理人:</span>
          <el-tag size="small" type="primary">{{ getAcceptorName(template.ticket_accept) }}</el-tag>
        </div>

        <div class="info-item">
          <el-icon size="14">
            <Clock />
          </el-icon>
          <span class="info-label">时限:</span>
          <el-tag size="small">{{ template.ticket_accept_days }}天受理</el-tag>
          <el-tag size="small">{{ template.ticket_process_days }}天处理</el-tag>
        </div>

        <div class="info-item">
          <el-icon size="14">
            <UserFilled />
          </el-icon>
          <span class="info-label">流程人:</span>
          <div class="process-people">
            <el-tag 
              v-for="(person, index) in getProcessPeople(template.ticket_process)" 
              :key="index" 
              size="small"
              type="info"
              class="mr-1"
            >
              {{ person }}
            </el-tag>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { User, UserFilled, Clock } from '@element-plus/icons-vue'

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
  template: TemplateData
  selected: boolean
  userMap: Map<number, string>
}

const props = defineProps<Props>()

// Emits
const emit = defineEmits<{
  select: [template: TemplateData]
}>()

// 方法
const handleSelect = () => {
  emit('select', props.template)
}

const getAcceptorName = (acceptorId: number): string => {
  return props.userMap.get(acceptorId) || acceptorId.toString()
}

const getProcessPeople = (processString: string): string[] => {
  if (!processString) return []
  try {
    const process = JSON.parse(processString)
    return Array.isArray(process) ? process : []
  } catch {
    return processString.split(',').filter(Boolean)
  }
}
</script>

<style scoped>
.template-card {
  border: 1px solid var(--el-border-color);
  border-radius: 8px;
  padding: 16px;
  margin-bottom: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  background-color: var(--el-bg-color);
}

.template-card:hover {
  border-color: var(--el-color-primary);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.template-card.selected {
  border-color: var(--el-color-primary);
  background-color: var(--el-color-primary-light-9);
  box-shadow: 0 2px 8px rgba(64, 158, 255, 0.2);
}

.card-content {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 8px;
}

.template-name {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
  color: var(--el-text-color-primary);
  flex: 1;
  line-height: 1.4;
}

.template-description {
  color: var(--el-text-color-regular);
  font-size: 14px;
  line-height: 1.5;
  margin: 0;
}

.template-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
}

.info-label {
  color: var(--el-text-color-regular);
  min-width: 50px;
}

.process-people {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
}

.mr-1 {
  margin-right: 4px;
}

/* 响应式设计 */
@media (max-width: 768px) {
  .template-card {
    padding: 12px;
    margin-bottom: 8px;
  }
  
  .card-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
  }
  
  .template-name {
    font-size: 15px;
  }
  
  .info-item {
    font-size: 12px;
  }
}
</style>
