<template>
  <el-form 
    :model="formData" 
    label-width="80px" 
    ref="form" 
    v-loading="loading" 
    class="pr-4"
  >
    <div class="flex flex-row justify-between">
      <div class="w-1/2">
        <el-form-item
          label="姓名"
          prop="name"
          :rules="[
            { required: true, message: '姓名必须填写' },
            { type: 'string', message: '必须是字符串类型' },
            { min: 2, max: 32, message: '姓名长度必须在2-32个字符之间' }
          ]"
        >
          <el-input 
            v-model="formData.name" 
            placeholder="请填写姓名" 
            show-word-limit 
            maxlength="32" 
            clearable 
          />
        </el-form-item>
        
        <el-form-item
          label="电话"
          prop="phone"
          :rules="[
            { required: true, message: '电话必须填写' },
            { pattern: /^1[3-9]\d{9}$/, message: '请输入正确的11位手机号码' },
            { len: 11, message: '手机号必须是11位' }
          ]"
        >
          <el-input 
            v-model="formData.phone" 
            placeholder="请填写电话" 
            show-word-limit 
            maxlength="11" 
            clearable 
          />
        </el-form-item>
        
        <el-form-item 
          label="设备名称" 
          prop="device_name" 
          :rules="[
            { required: true, message: '设备名称字段必须填写' },
            { type: 'string', message: '必须是字符串类型' },
            { max: 255, message: '设备名称长度不能超过255个字符' },
            { pattern: /^[^\/]+\/[^\/]+\/[^\/]+$/, message: '设备名称格式必须为[设备类型]/[品牌]/[型号]' }
          ]"
        >
          <el-input 
            v-model="formData.device_name" 
            placeholder="格式：[设备类型]/[品牌]/[型号]" 
            show-word-limit 
            maxlength="255" 
            clearable 
          />
        </el-form-item>
        
        <el-form-item 
          label="设备mac" 
          prop="device_mac" 
          :rules="[
            { required: true, message: '设备mac字段必须填写' },
            { pattern: /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/, message: '请输入正确的MAC地址格式，如AA:BB:CC:DD:EE:FF' },
            { len: 17, message: 'MAC地址长度必须为17位' }
          ]"
        >
          <el-input 
            v-model="formData.device_mac" 
            placeholder="请填写设备MAC，格式如AA:BB:CC:DD:EE:FF" 
            show-word-limit 
            maxlength="17" 
            clearable 
          />
        </el-form-item>
      </div>

      <div class="w-1/2">
        <el-form-item 
          label="部门" 
          prop="department_id" 
          :rules="[{ required: true, message: '部门必须选择' }]"
        >
          <el-tree-select 
            class="w-full" 
            v-model="formData.department_id" 
            :data="departments" 
            check-strictly 
            :props="{ label: 'department_name', value: 'id' }" 
            placeholder="请选择部门"
          />
        </el-form-item>
        
        <el-form-item 
          label="岗位" 
          prop="positions_id" 
          :rules="[{ required: true, message: '岗位必须选择' }]"
        >
          <el-select 
            class="w-full" 
            v-model="formData.positions_id" 
            placeholder="请选择岗位"
          >
            <el-option 
              v-for="item in jobs" 
              :key="item.id" 
              :label="item.job_name" 
              :value="item.id" 
            />
          </el-select>
        </el-form-item>
        
        <el-form-item 
          label="设备申请" 
          prop="device_apply"
          :rules="[{ max: 1024, message: '申请理由长度不能超过1024个字符' }]"
        >
          <el-input 
            v-model="formData.device_apply" 
            type="textarea" 
            rows="4" 
            placeholder="请填写设备申请说明" 
            show-word-limit
            maxlength="1024"
            clearable 
          />
        </el-form-item>
      </div>
    </div>
    
    <div class="flex justify-end">
      <el-button 
        type="primary" 
        @click="submitForm(form)"
      >
        {{ $t('system.confirm') }}
      </el-button>
    </div>
  </el-form>
</template>

<script lang="ts" setup>
  // @ts-nocheck
  import { useCreate } from '@/composables/curd/useCreate'
  import { useShow } from '@/composables/curd/useShow'
  import { inject, onMounted, ref } from 'vue'
  import http from '@/support/http'

  const props = defineProps({
    primary: [String, Number],
    api: String,
    width: [String, Number]
  })

  const { 
    formData, 
    form, 
    loading, 
    submitForm, 
    close 
  } = useCreate(props.api as string, props.primary)

  if (props.primary) {
    useShow(props.api as string, props.primary, formData)
  }

  const closeDialog = inject('closeDialog') as Function
  const departments = ref()
  const jobs = ref()

  onMounted(() => {
    // 获取部门数据
    http.get('permissions/departments')
      .then(r => {
        departments.value = r.data.data
      })

    // 获取岗位数据
    http.get('permissions/jobs')
      .then(r => {
        jobs.value = r.data.data
      })
    
    close(() => closeDialog())
  })
</script>
