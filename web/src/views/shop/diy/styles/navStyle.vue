<template>
  <div>
    <div class="text-base h-10 flex items-center pl-5 pr-5 border-b border-gray-200">{{ nav.title }}</div>
    <el-tabs v-model="activeName" class="pr-2 pl-2">
      <el-tab-pane label="内容" name="content">
        <div class="text-xs text-gray-400">最多可添加1张图片，建议宽度90 * 90px,标题建议不超过四个字</div>
        <div class="grid grid-cols-3 min-h-0 pt-2 pb-2 border-b border-gray-200 mt-2" v-for="(item, key) in nav.data" :key="key">
          <div class="pr-1 flex justify-between">
            <div class="flex items-center cursor-move">
              <Icon name="list-bullet" />
            </div>
            <AttachUpload v-model="item.icon" name="images" :image-width="20" />
          </div>
          <div class="col-span-2 flex flex-col items-center justify-center gap-y-4">
            <el-input v-model="item.title" maxlength="10" placeholder="请输入标题" show-word-limit type="text" />
            <el-input v-model="item.url" placeholder="请输入链接" show-word-limit type="text" />
          </div>
        </div>
        <div class="w-full"><el-button type="primary" class="w-full mt-2" @click="addNav">新增</el-button></div>
      </el-tab-pane>
      <el-tab-pane label="样式" name="style">
        <el-card shadow="never">
          <template #header>
            <div>样式设置</div>
          </template>
          <div>
            <div class="flex flex-col">
              <el-form-item label="图标形状">
                <el-radio-group v-model="nav.style.shape" size="small">
                  <el-radio-button value="square">方形</el-radio-button>
                  <el-radio-button value="circle">圆形</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="文字颜色">
                <el-color-picker v-model="nav.style.color" size="small" />
              </el-form-item>
              <el-form-item label="显示列数">
                <el-radio-group v-model="nav.style.cols" size="small">
                  <el-radio-button :value="2">2</el-radio-button>
                  <el-radio-button :value="3">3</el-radio-button>
                  <el-radio-button :value="4">4</el-radio-button>
                  <el-radio-button :value="5">5</el-radio-button>
                  <el-radio-button :value="6">6</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="背景颜色">
                <el-color-picker v-model="nav.style.background_color" size="small" />
              </el-form-item>
              <el-form-item label="上边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="nav.style.pt" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ nav.style.pt }}</div>
                </div>
              </el-form-item>
              <el-form-item label="下边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="nav.style.pb" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ nav.style.pb }}</div>
                </div>
              </el-form-item>
              <el-form-item label="左边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="nav.style.pl" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ nav.style.pl }}</div>
                </div>
              </el-form-item>
              <el-form-item label="右边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="nav.style.pr" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ nav.style.pr }}</div>
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
import { NavComponent } from '../component'

const activeName = ref('content')

const nav = defineModel<NavComponent>({ required: true })

const addNav = () => {
  nav.value.data.push({
    title: '',
    icon: '',
    url: ''
  })
}

onMounted(() => {
  addNav()
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
