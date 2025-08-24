<template>
  <div>
    <div class="text-base h-10 flex items-center pl-5 pr-5 border-b border-gray-200">{{ swiper.title }}</div>
    <el-tabs v-model="activeName" class="pr-2 pl-2">
      <el-tab-pane label="内容" name="content">
        <div class="text-xs text-gray-400">最多可添加10张图片，建议宽度750px；鼠标拖拽左侧圆点可调整图片 顺序</div>
        <div class="grid grid-cols-3 min-h-0 pt-2 pb-2 border-b border-gray-200 mt-2" v-for="(item, key) in swiper.data" :key="key">
          <div class="pr-1 flex justify-between">
            <div class="flex items-center cursor-move">
              <Icon name="list-bullet" />
            </div>
            <AttachUpload v-model="item.image" name="images" :image-width="20" />
          </div>
          <div class="col-span-2 flex flex-col items-center justify-center gap-y-4">
            <el-input v-model="item.title" maxlength="15" placeholder="请输入标题" show-word-limit type="text" />
            <el-input v-model="item.url" placeholder="请输入链接" show-word-limit type="text" />
          </div>
        </div>
        <div class="w-full"><el-button type="primary" class="w-full mt-2" @click="addSwiper">新增</el-button></div>
      </el-tab-pane>
      <el-tab-pane label="样式" name="style">
        <el-card shadow="never">
          <template #header>
            <div>指示器设置</div>
          </template>
          <div>
            <div class="flex flex-col">
              <el-form-item label="是否显示">
                <el-radio-group v-model="swiper.style.indicator.is_show" size="small">
                  <el-radio-button :value="true">显示</el-radio-button>
                  <el-radio-button :value="false">隐藏</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="指示器样式">
                <el-radio-group v-model="swiper.style.indicator.mode" size="small">
                  <el-radio-button label="line">直线</el-radio-button>
                  <el-radio-button label="dot">圆形</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="指示器位置">
                <el-radio-group v-model="swiper.style.indicator.position" size="small">
                  <el-radio-button label="bottom">底部</el-radio-button>
                  <el-radio-button label="left">左侧</el-radio-button>
                  <el-radio-button label="right">右侧</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="激活颜色">
                <el-color-picker v-model="swiper.style.indicator.active_color" size="small" />
              </el-form-item>
              <el-form-item label="非激活颜色">
                <el-color-picker v-model="swiper.style.indicator.inactive_color" size="small" />
              </el-form-item>
            </div>
          </div>
        </el-card>

        <el-card shadow="never">
          <template #header>
            <div>样式设置</div>
          </template>
          <div>
            <div class="flex flex-col">
              <el-form-item label="轮播图圆角">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="swiper.style.border_radius" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ swiper.style.border_radius }}</div>
                </div>
              </el-form-item>
              <el-form-item label="背景颜色">
                <el-color-picker v-model="swiper.style.background_color" size="small" />
              </el-form-item>
              <el-form-item label="上边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="swiper.style.pt" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ swiper.style.pt }}</div>
                </div>
              </el-form-item>
              <el-form-item label="下边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="swiper.style.pb" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ swiper.style.pb }}</div>
                </div>
              </el-form-item>
              <el-form-item label="左边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="swiper.style.pl" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ swiper.style.pl }}</div>
                </div>
              </el-form-item>
              <el-form-item label="右边距">
                <div class="grid grid-cols-4 w-full gap-x-4">
                  <el-slider v-model="swiper.style.pr" size="small" class="col-span-3" />
                  <div class="w-7 h-7 text-xs rounded-md border border-gray-300 flex items-center justify-center">{{ swiper.style.pr }}</div>
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
import { swiperComponent } from '../component'

const activeName = ref('content')

const swiper = defineModel<swiperComponent>({ required: true })

const addSwiper = () => {
  swiper.value.data.push({
    image: '',
    title: '',
    url: ''
  })
}

onMounted(() => {
  console.log(123123)

  addSwiper()
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
