<template>
  <div>
    <div class="flex items-center h-10 pl-5 pr-5 text-base border-b border-gray-200">{{ announces.title }}</div>
    <el-tabs v-model="activeName" class="pl-2 pr-2">
      <el-tab-pane label="内容" name="content">
        <div>
          <el-form-item label="滚动方式">
            <el-radio-group v-model="announces.type" class="ml-4">
              <el-radio value="level">水平方向</el-radio>
              <el-radio value="vertical">垂直方向</el-radio>
            </el-radio-group>
          </el-form-item>
        </div>

        <div class="mt-2 text-gray-400 text">添加公告内容</div>
        <div class="min-h-0 pt-2 pb-2 mt-2 border-b border-gray-200" v-for="(item, key) in announces.data" :key="key">
          <div class="flex flex-col items-center justify-center col-span-2 gap-y-4">
            <el-input v-model="item.title" maxlength="20" placeholder="请输入标题" show-word-limit type="text" />
            <el-input v-model="item.url" placeholder="请输入链接" show-word-limit type="text" />
          </div>
        </div>
        <div class="w-full"><el-button type="primary" class="w-full mt-2" @click="addAnnounce">新增</el-button></div>
      </el-tab-pane>
      <el-tab-pane label="样式" name="style">
        <el-card shadow="never">
          <template #header>
            <div>样式设置</div>
          </template>
          <div>
            <div class="flex flex-col">
              <el-form-item label="文字颜色">
                <el-color-picker v-model="announces.style.color" size="small" />
              </el-form-item>
              <el-form-item label="文字大小">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="announces.style.size" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ announces.style.size }}</div>
                </div>
              </el-form-item>
              <el-form-item label="背景颜色">
                <el-color-picker v-model="announces.style.background_color" size="small" />
              </el-form-item>
              <el-form-item label="上边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="announces.style.pt" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ announces.style.pt }}</div>
                </div>
              </el-form-item>
              <el-form-item label="下边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="announces.style.pb" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ announces.style.pb }}</div>
                </div>
              </el-form-item>
              <el-form-item label="左边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="announces.style.pl" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ announces.style.pl }}</div>
                </div>
              </el-form-item>
              <el-form-item label="右边距">
                <div class="grid w-full grid-cols-4 gap-x-4">
                  <el-slider v-model="announces.style.pr" size="small" class="col-span-3" />
                  <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ announces.style.pr }}</div>
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
import { ref, onMounted } from 'vue'
import { AnnounceComponent } from '../component'

const announces = defineModel<AnnounceComponent>({ required: true })

const activeName = ref('content')

const addAnnounce = () => {
  announces.value.data.push({
    title: '',
    url: ''
  })
}

onMounted(() => {
  addAnnounce()
})
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
