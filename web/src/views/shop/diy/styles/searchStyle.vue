<template>
  <div>
    <div class="text-base h-10 flex items-center pl-5 pr-5 border-b border-gray-200">{{ search.title }}</div>
    <el-tabs v-model="activeName" class="pr-2 pl-2">
      <el-tab-pane label="内容" name="content">
        <div class="text-xs text-gray-400">搜索框提示文字</div>
        <el-input v-model="search.placeholder" class="mt-5" />
      </el-tab-pane>
      <el-tab-pane label="样式" name="style">
        <el-card shadow="never">
          <template #header>
            <div>样式设置</div>
          </template>
          <div>
            <div class="flex flex-col">
              <el-form-item label="文本颜色">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-color-picker v-model="search.style.color" size="small" />
                </div>
              </el-form-item>
              <el-form-item label="文本位置">
                <el-radio-group v-model="search.style.position" size="small">
                  <el-radio-button value="left">左侧</el-radio-button>
                  <el-radio-button value="center">居中</el-radio-button>
                  <el-radio-button value="right">右侧</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="文本尺寸">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="search.style.size" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ search.style.size }}</div>
                </div>
              </el-form-item>
              <el-form-item label="圆角设置">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="search.style.border_radius" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ search.style.border_radius }}</div>
                </div>
              </el-form-item>
              <el-form-item label="背景颜色">
                <el-color-picker v-model="search.style.background_color" size="small" />
              </el-form-item>
              <el-form-item label="上边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="search.style.pt" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ search.style.pt }}</div>
                </div>
              </el-form-item>
              <el-form-item label="下边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="search.style.pb" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ search.style.pb }}</div>
                </div>
              </el-form-item>
              <el-form-item label="左边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="search.style.pl" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ search.style.pl }}</div>
                </div>
              </el-form-item>
              <el-form-item label="右边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="search.style.pr" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ search.style.pr }}</div>
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
import { searchComponent } from '../component'

const activeName = ref('content')

const search = defineModel<searchComponent>({ required: true })

search.value.placeholder = '请输入搜索商品'
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

.el-input {
  border-radius: 0px;
}
</style>
