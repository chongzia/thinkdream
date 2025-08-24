<template>
  <div>
    <div class="flex items-center h-10 pl-5 pr-5 text-base border-b border-gray-200">{{ title.title }}</div>
    <el-tabs v-model="activeName" class="pl-2 pr-2">
      <el-tab-pane label="内容" name="content">
        <div>
          <el-form-item label="位置">
            <el-radio-group v-model="title.style.position" class="ml-4">
              <el-radio value="left">左侧</el-radio>
              <el-radio value="center">居中</el-radio>
              <el-radio value="right">右侧</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="标题内容">
            <el-input v-model="title.data.title" maxlength="20" placeholder="请输入标题" show-word-limit type="text" />
            <el-input v-model="title.data.url" placeholder="请输入链接" show-word-limit type="text" class="mt-2" />
          </el-form-item>
        </div>
      </el-tab-pane>
      <el-tab-pane label="样式" name="style">
        <el-card shadow="never">
          <template #header>
            <div>样式设置</div>
          </template>
          <div>
            <div class="flex flex-col">
              <el-form-item label="文字颜色">
                <el-color-picker v-model="title.style.color" size="small" />
              </el-form-item>
              <el-form-item label="文字大小">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="title.style.size" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ title.style.size }}</div>
                </div>
              </el-form-item>
              <el-form-item label="背景颜色">
                <el-color-picker v-model="title.style.background_color" size="small" />
              </el-form-item>
              <el-form-item label="上边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="title.style.pt" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ title.style.pt }}</div>
                </div>
              </el-form-item>
              <el-form-item label="下边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="title.style.pb" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ title.style.pb }}</div>
                </div>
              </el-form-item>
              <el-form-item label="左边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="title.style.pl" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ title.style.pl }}</div>
                </div>
              </el-form-item>
              <el-form-item label="右边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="title.style.pr" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ title.style.pr }}</div>
                </div>
              </el-form-item>
            </div>
          </div>
        </el-card>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { TitleComponent } from '../component'

const title = defineModel<TitleComponent>({ required: true })

const activeName = ref('content')
</script>

<style scoped>
.el-card__header {
  padding: 5px !important;
}
.el-card__body {
  .el-form-item__label {
    font-size: 13px !important;
  }
}
</style>
