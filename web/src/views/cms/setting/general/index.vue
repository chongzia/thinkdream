<template>
  <layout title="常规选项">
    <template v-slot:body>
      <el-form :model="formData" label-width="120px" ref="form" class="w-full pt-5 pr-4 bg-white dark:bg-regal-dark">
        <div class="flex flex-col w-2/3 mx-auto">
          <el-form-item
            label="站点名称"
            prop="site_title"
            :rules="[
              {
                required: true,
                message: '站点名称必须填写'
              }
            ]"
          >
            <el-input v-model="formData.site_title" clearable />
          </el-form-item>

          <el-form-item label="站点Logo" prop="site_logo">
            <UploadImage v-model="formData.site_logo" />
          </el-form-item>

          <el-form-item label="站点链接" prop="site_url">
            <el-input v-model="formData.site_url" clearable />
          </el-form-item>

          <el-form-item label="站点关键字" prop="site_keywords">
            <el-input v-model="formData.site_keywords" clearable />
          </el-form-item>

          <el-form-item label="站点描述" prop="site_description">
            <el-input v-model="formData.site_description" clearable type="textarea" />
          </el-form-item>

          <el-form-item label="日期格式" prop="site_date_format">
            <el-radio-group v-model="formData.site_date_format">
              <el-radio-button value="年-月-日">年-月-日</el-radio-button>
              <el-radio-button value="Y-m-d">Y-m-d</el-radio-button>
              <el-radio-button value="m/d/Y">m/d/Y</el-radio-button>
              <el-radio-button value="d/m/Y">d/m/Y</el-radio-button>
            </el-radio-group>
          </el-form-item>

          <el-form-item label="时间格式" prop="site_time_format">
            <el-radio-group v-model="formData.site_time_format">
              <el-radio-button value="ag:i">ag:i (下午1:10)</el-radio-button>
              <el-radio-button value="g:i A">g:i A (1:10 下午)</el-radio-button>
              <el-radio-button value="H:i">H:i (1:10)</el-radio-button>
            </el-radio-group>
          </el-form-item>

          <el-form-item label="备案号" prop="site_case_number">
            <el-input v-model="formData.site_case_number" clearable />
          </el-form-item>

          <el-form-item label="站点版权" prop="site_case_number">
            <el-input v-model="formData.site_copyright" clearable />
          </el-form-item>

          <el-form-item label="第三方统计代码" prop="site_script">
            <el-input v-model="formData.site_script" clearable type="textarea" />
          </el-form-item>
        </div>
        <div class="flex justify-center mb-3 bg-white dark:bg-regal-dark">
          <el-button type="primary" @click="submitForm(form)" class="ml-5 w-[10rem]">保 存</el-button>
        </div>
      </el-form>
    </template>
  </layout>
</template>

<script setup lang="ts">
// @ts-nocheck
import Layout from '../layout.vue'
import { useCreate } from '@/composables/curd/useCreate'
import http from '@/support/http'
const api = '/cms/setting'

const { formData, form, submitForm } = useCreate(api)

http.get('cms/setting').then(r => {
  formData.value = r.data.data
})

const uploadSuccess = r => {
  formData.value.site_logo = r.data.path
}
</script>
