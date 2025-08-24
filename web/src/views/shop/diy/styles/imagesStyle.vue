<template>
  <div>
    <div class="flex items-center h-10 pl-5 pr-5 text-base border-b border-gray-200">{{ images.title }}</div>
    <el-card shadow="never">
      <div>
        <div class="flex flex-col">
          <el-form-item label="类型">
            <el-radio-group v-model="images.style.type" size="small">
              <el-radio-button :value="1" border>
                <div class="grid items-center justify-center w-4 h-4 grid-cols-1">
                  <span class="w-3 h-2 bg-black"></span>
                </div>
              </el-radio-button>
              <el-radio-button :value="2" border>
                <div class="grid items-center justify-center w-4 h-4 grid-flow-col gap-x-1">
                  <span class="w-1 h-2 bg-black"></span>
                  <span class="w-1 h-2 bg-black"></span>
                </div>
              </el-radio-button>
              <el-radio-button :value="3" border>
                <div class="grid items-center w-4 h-4 grid-cols-3 gap- justify-center1">
                  <span class="w-1 h-2 bg-black"></span>
                  <span class="w-1 h-2 bg-black"></span>
                  <span class="w-1 h-2 bg-black"></span>
                </div>
              </el-radio-button>
              <el-radio-button :value="4" border>
                <div class="grid grid-flow-col gap-[2px] grid-rows-2 w-4 h-4 items-center justify-center">
                  <span class="w-1 h-4 row-span-2 bg-black"></span>
                  <span class="w-1 h-2 row-span-1 bg-black"></span>
                  <span class="w-1 h-2 row-span-1 bg-black"></span>
                </div>
              </el-radio-button>
              <el-radio-button :label="5" border>
                <div class="grid items-center justify-center w-4 h-4 grid-cols-4 gap-1">
                  <span class="w-1 h-2 bg-black"></span>
                  <span class="w-1 h-2 bg-black"></span>
                  <span class="w-1 h-2 bg-black"></span>
                  <span class="w-1 h-2 bg-black"></span>
                </div>
              </el-radio-button>
              <el-radio-button :label="6" border>
                <div class="grid grid-cols-2 gap-[0.15rem] grid-rows-2 w-4 h-4 items-center justify-center">
                  <span class="w-2 h-2 row-span-1 bg-black"></span>
                  <span class="w-2 h-2 row-span-1 bg-black"></span>
                  <span class="w-2 h-2 row-span-1 bg-black"></span>
                  <span class="w-2 h-2 row-span-1 bg-black"></span>
                </div>
              </el-radio-button>
            </el-radio-group>
          </el-form-item>
          <div>
            <div class="text-xs text-gray-400">最多可添加1张图片，建议宽度90 * 90px,标题建议不超过四个字</div>
            <!--预览-->
            <div v-if="images.style.type !== 6 && images.style.type !== 4 && images.style.type !== 5" :class="`grid grid-cols-${images.style.type} gap-1`">
              <div v-for="(item, key) in images.data" :key="key" @click="selectImg(key)" class="bg-gray-300 cursor-pointer">
                <img :src="item.image" :class="'w-full h-' + 72 / images.style.type" v-if="item.image" />
                <div v-else :class="'w-full h-' + 72 / images.style.type + ' opacity-55'"></div>
              </div>
            </div>
            <div v-else-if="images.style.type === 4" class="grid grid-flow-col gap-[2px] grid-rows-2">
              <div @click="selectImg(key)" :class="'bg-gray-300 cursor-pointer w-full row-span-' + (!key ? 2 : 1) + ' bg-black h-' + (!key ? 36 : 18)" v-for="(item, key) in images.data" :key="key">
                <img :src="item.image" class="w-full h-full" v-if="item.image" />
              </div>
            </div>
            <div v-else-if="images.style.type === 5" class="grid grid-cols-4 gap-x-1">
              <div class="w-full h-16 bg-gray-300 cursor-pointer opacity-55" v-for="(item, key) in images.data" :key="key" @click="selectImg(key)">
                <img :src="item.image" class="w-full h-full" v-if="item.image" />
              </div>
            </div>
            <div v-else class="grid grid-cols-2 gap-[0.15rem] grid-rows-2">
              <div class="w-full row-span-1 bg-gray-300 cursor-pointer h-36" v-for="(item, key) in images.data" :key="key" @click="selectImg(key)">
                <img :src="item.image" class="w-full h-full" v-if="item.image" />
              </div>
            </div>

            <!--新增图片-->
            <div class="grid min-h-0 grid-cols-3 pt-2 pb-2 mt-2 border-b border-gray-200 gay-x-2">
              <div>
                <AttachUpload v-model="activeImg.image" name="images" :image-width="20" />
              </div>
              <div class="flex flex-col items-center justify-center col-span-2 gap-y-4">
                <el-input v-model="activeImg.url" placeholder="请输入链接" show-word-limit type="text" />
              </div>
            </div>
          </div>
          <el-form-item label="背景颜色">
            <el-color-picker v-model="images.style.background_color" size="small" />
          </el-form-item>
          <el-form-item label="上边距">
            <div class="grid w-full grid-cols-4 gap-x-4">
              <el-slider v-model="images.style.pt" size="small" class="col-span-3" />
              <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ images.style.pt }}</div>
            </div>
          </el-form-item>
          <el-form-item label="下边距">
            <div class="grid w-full grid-cols-4 gap-x-4">
              <el-slider v-model="images.style.pb" size="small" class="col-span-3" />
              <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ images.style.pb }}</div>
            </div>
          </el-form-item>
          <el-form-item label="左边距">
            <div class="grid w-full grid-cols-4 gap-x-4">
              <el-slider v-model="images.style.pl" size="small" class="col-span-3" />
              <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ images.style.pl }}</div>
            </div>
          </el-form-item>
          <el-form-item label="右边距">
            <div class="grid w-full grid-cols-4 gap-x-4">
              <el-slider v-model="images.style.pr" size="small" class="col-span-3" />
              <div class="flex items-center justify-center text-xs border border-gray-300 rounded-md w-7 h-7">{{ images.style.pr }}</div>
            </div>
          </el-form-item>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { ImagesComponent } from '../component'

const images = defineModel<ImagesComponent>({ required: true })

const addImage = () => {
  images.value.data.push({
    image: '',
    url: ''
  })
}

const removeImage = () => {
  images.value.data.pop()
}

addImage()

const activeImg = ref(images.value.data[0])
const selectImg = (k: number) => {
  activeImg.value = images.value.data[k]
}

watch(
  () => images.value.style.type,
  (newValue, oldValue) => {
    const len = images.value.data.length

    let newLen = 0
    if (newValue === 5 || newValue === 6) {
      newLen = 4
    } else if (newValue === 4) {
      newLen = 3
    } else {
      newLen = newValue
    }

    if (len !== newLen) {
      if (len < newLen) {
        for (let i = 0; i < newLen - len; i++) {
          addImage()
        }
      } else {
        for (let i = 0; i < len - newLen; i++) {
          removeImage()
        }
      }
    }
  }
)
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

:deep(.el-radio-button__original-radio:checked + .el-radio-button__inner) {
  background-color: white !important;
}
</style>
