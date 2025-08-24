<template>
  <BaseCard :title="template.ticket_name" :description="template.ticket_description || '暂无描述'" :selected="selected"
    :right-top-badge="{ text: `#${template.id}`, type: 'info' }" @click="handleSelect">
    <template #info>
      <div class="template-info">
        <div class="info-row">
          <el-icon size="14">
            <User />
          </el-icon>
          <span class="info-label">受理人:</span>
          <el-tag size="small" type="primary">{{ getAcceptorName(template.ticket_accept) }}</el-tag>
        </div>

        <div class="info-row">
          <el-icon size="14">
            <Clock />
          </el-icon>
          <span class="info-label">时限:</span>
          <el-tag size="small">{{ template.ticket_accept_days }}天受理</el-tag>
          <el-tag size="small" type="warning">{{ template.ticket_process_days }}天处理</el-tag>
        </div>

        <div class="info-row">
          <el-icon size="14">
            <UserFilled />
          </el-icon>
          <span class="info-label">流程人:</span>
          <el-tag v-for="(person, index) in getProcessPeople(template.ticket_process)" :key="index" size="small"
            type="warning">
            {{ person }}
          </el-tag>
        </div>
      </div>
    </template>

    <template #footer>
      <div class="footer-content">
        <el-tag :type="template.ticket_is_active === 1 ? 'success' : 'warning'" size="small">
          {{ template.ticket_is_active === 1 ? '已启用' : '已禁用' }}
        </el-tag>

        <el-space>
          <el-button v-if="hasTemplateUpdatePermission" size="small" type="primary" text @click.stop="handleEdit">
            <el-icon size="14">
              <Edit />
            </el-icon>
            编辑
          </el-button>
          <el-button v-if="hasTemplateDestroyPermission" size="small" type="danger" text @click.stop="handleDelete">
            <el-icon size="14">
              <Delete />
            </el-icon>
            删除
          </el-button>
        </el-space>
      </div>
    </template>
  </BaseCard>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { User, UserFilled, Clock, Edit, Delete } from '@element-plus/icons-vue'
import BaseCard from '@/components/common/BaseCard.vue'
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

// 权限检查
const userStore = useUserStore()

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

const props = defineProps<{
  template: TemplateData
  selected: boolean
  userMap: Map<number, string>
}>()

const emit = defineEmits<{
  select: [template: TemplateData]
  edit: [template: TemplateData]
  delete: [template: TemplateData]
}>()

const getAcceptorName = (acceptorId: number): string => {
  return props.userMap?.get(acceptorId) || acceptorId.toString()
}

const getProcessPeople = computed(() => (processStr: any) => {
  if (!processStr) return []

  try {
    const parsed = typeof processStr === 'string' ? JSON.parse(processStr) : processStr
    if (Array.isArray(parsed)) {
      return parsed.map(id => props.userMap?.get(Number(id)) || id.toString())
    }
  } catch {
    if (typeof processStr === 'string') {
      const ids = processStr.split(',').map(id => id.trim()).filter(id => id)
      return ids.map(id => props.userMap?.get(Number(id)) || id.toString())
    }
  }

  return [props.userMap?.get(Number(processStr)) || processStr.toString()]
})

const handleSelect = () => emit('select', props.template)
const handleEdit = () => emit('edit', props.template)
const handleDelete = () => emit('delete', props.template)
</script>

<style scoped>
.template-info {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.info-row {
  display: flex;
  align-items: center;
  gap: 8px;
}

.info-label {
  font-size: 12px;
  color: var(--el-text-color-regular);
  min-width: 48px;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

@media (max-width: 768px) {
  .info-row {
    flex-wrap: wrap;
    gap: 4px;
  }

  .info-label {
    min-width: auto;
  }
}
</style>
