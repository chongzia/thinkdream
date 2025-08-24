<template>
  <div class="grid grid-cols-6 gap-4 p-10 min-h-80">
    <!-- 左侧可拖拽组件 -->
    <basic />
    <!--中间栏显示-->
    <div class="col-span-4 col-start-2 m-auto bg-white rounded-lg gap-y-10 dark:bg-regal-dark">
      <VueDraggable @add="add" class="min-h-screen w-[22rem] rounded-lg" v-model="activeComponents" animation="150" ghostClass="ghost" group="people">
        <div
          :class="'min-h-10 relative cursor-move ' + (component.active ? 'border-2 border-indigo-500 shadow-lg shadow-indigo-400/50' : 'border-2 border-indigo-600 border-dotted')"
          v-for="(component, k) in activeComponents"
          :key="k"
          v-on:click.stop="selectConponent(k)"
        >
          <component :is="components[component.name]" v-model="activeComponents[k]" />

          <!--侧边操作栏-->
          <div class="top-0 -right-14 z-[1000] w-10 absolute flex flex-col gap-y-5 items-center rounded-md cursor-pointer" v-if="component.active">
            <div class="flex flex-col w-full h-24 bg-white divide-y rounded-full dark:bg-regal-dark divide-dashed">
              <el-tooltip effect="dark" placement="right" content="上移">
                <div @click.stop="up(k)" class="flex items-center justify-center h-12"><Icon name="chevron-up" /></div>
              </el-tooltip>
              <el-tooltip effect="dark" placement="right" content="下移">
                <div @click.stop="down(k)" class="flex items-center justify-center h-12"><Icon name="chevron-down" /></div>
              </el-tooltip>
            </div>
            <el-tooltip effect="dark" placement="right" content="复制">
              <div @click.stop="copy(k)" class="flex items-center justify-center w-full h-10 bg-white rounded-full dark:bg-regal-dark">
                <Icon name="document-duplicate" />
              </div>
            </el-tooltip>
            <el-tooltip effect="dark" placement="right" content="删除">
              <div @click.stop="destroy(k)" class="flex items-center justify-center w-full h-10 bg-white rounded-full dark:bg-regal-dark"><Icon name="trash" /></div>
            </el-tooltip>
          </div>
        </div>
      </VueDraggable>
    </div>
    <!-- 左侧可拖拽组件 -->
    <div class="bg-white dark:bg-regal-dark">
      <KeepAlive>
        <component :is="componentStyles[activeComponent?.name + 'Style']" v-model="activeComponent" />
      </KeepAlive>
    </div>
  </div>
</template>

<script lang="ts" setup>
// @ts-nocheck
import Message from '@/support/message'
import { ref, toRaw, reactive } from 'vue'
import { VueDraggable } from 'vue-draggable-plus'
import basic from './basic.vue'
import { components, componentStyles } from '../componentsMap'
import { component as componentInterface } from '../component'
const activeComponents = ref<Array<componentInterface>>([])

const activeComponent = ref()

// 监听列表新增元素
const add = (event: any) => {
  activeComponents.value = activeComponents.value.map((element: any) => {
    element.active = false
    return element
  })

  activeComponents.value[event.newDraggableIndex].active = true
  activeComponent.value = activeComponents.value[event.newDraggableIndex]
}
// 组件元素操作
// 上移元素
const up = (k: number) => {
  if (k === 0) {
    return
  }
  console.log(activeComponents.value)
  ;[activeComponents.value[k - 1], activeComponents.value[k]] = [activeComponents.value[k], activeComponents.value[k - 1]]
}
// 下移元素
const down = (k: number) => {
  if (k === activeComponents.value.length - 1) {
    return
  }

  ;[activeComponents.value[k + 1], activeComponents.value[k]] = [activeComponents.value[k], activeComponents.value[k + 1]]
}
// 删除元素
const destroy = (k: number) => {
  Message.confirm('确定删除该元素吗?', () => {
    activeComponents.value = activeComponents.value.filter((item, key) => {
      return key !== k
    })

    if (activeComponents.value.length > 0) {
      activeComponents.value[k - 1].active = true
    }
  })
}
// 复制元素
const copy = (k: number) => {
  // 复制的元素
  const copyEle = Object.assign(JSON.parse(JSON.stringify({ ...toRaw(activeComponents.value[k]) })))
  // 原元素失去激活状态
  activeComponents.value[k].active = false
  // 将复制的元素插入到原元素之后
  const newEles: Array<any> = []
  activeComponents.value.forEach((ele, key) => {
    newEles.push(ele)
    if (key === k) {
      newEles.push(reactive(copyEle))
    }
  })
  activeComponents.value = newEles
}

// 选中组件
const selectConponent = (k: number) => {
  activeComponents.value = activeComponents.value.map((item, key) => {
    item.active = k === key
    return item
  })

  activeComponent.value = activeComponents.value[k]
}
</script>
<style scoped>
.el-card {
  @apply border-none;
}
</style>
