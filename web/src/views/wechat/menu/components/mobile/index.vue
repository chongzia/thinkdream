<template>
  <div class="flex flex-col justify-center items-center w-full bg-white dark:bg-regal-dark">
    <div class="w-full sm:w-2/3 flex py-2 sm:py-5 px-5 sm:px-5 justify-between">
      <!-- mobile -->
      <div class="w-full sm:w-80 rounded-xl shadow-lg">
        <div class="w-full h-[2.5rem] bg-gray-100 rounded-t-xl flex justify-between pt-3 pl-2 pr-2">
          <div><Icon name="arrow-left" className="w-4 h-4 text-slate-600" /></div>
          <div class="text-sm text-slate-700">微信管理</div>
          <div><Icon name="user" className="w-4 h-4 text-slate-700" /></div>
        </div>
        <div class="w-full h-[28rem] border-l border-r border-solid border-gray-100"></div>
        <div class="w-full h-[3rem] flex bg-gray-100 rounded-b-xl">
          <div class="w-8 pl-2 pr-2 pt-4"><Icon name="code-bracket" className="w-4 h-4 text-slate-500" /></div>
          <div class="flex w-full items-center">
            <div v-for="(item, key) in buttons.buttons" :key="key" class="w-full relative pt-4 text-xs h-[3rem] text-slate-500 text-center cursor-pointer border-l border-solid border-gray-300">
              <div class="absolute top-0 right-0 w-4 h-4 leading-3 mb-1 border border-solid border-gray-200 rounded-full" @click="deleteButton(key)" v-if="item.name !== '+'">x</div>
              <div @click="addButton(item)" class="w-full text-center h-full" v-if="item.name === '+'">{{ item.name }}</div>
              <el-popover v-else placement="top" :width="100" :visible="isButtonActive === key" :offset="22">
                <template #reference>
                  <div class="w-full h-[2rem] text-center" @click="selectMenu(item, key)" ref="buttonRef">{{ item.name }}</div>
                </template>
                <div class="w-full">
                  <div v-for="(subItem, index) in item.sub_buttons" :key="index" class="w-full relative text-center cursor-pointer border-buttom border-solid border-gray-300">
                    <div class="absolute top-0 -right-2 leading-3 w-4 h-4 rounded-full mb-1 border border-solid border-gray-200" v-if="subItem.name !== '+'" @click="deleteSubButton(index, key)">
                      x
                    </div>
                    <div class="w-full text-center h-12 pt-4 border-b border-solid border-gray-100" @click="AddSubButton(item.sub_buttons)" v-if="subItem.name === '+'">{{ subItem.name }}</div>
                    <div class="w-full h-12 text-center pt-4 border-b border-solid border-gray-100" v-else @click="selecSubtMenu(subItem, index)" ref="buttonRef">{{ subItem.name }}</div>
                  </div>
                </div>
              </el-popover>
            </div>
          </div>
        </div>
      </div>
      <!--form -->
      <div class="w-[30rem]">
        <el-form :model="menu" label-width="120px" ref="form" class="mt-28">
          <el-form-item label="菜单名称" prop="name" :rules="[{ required: true, message: '菜单名称必须填写' }]">
            <el-input v-model="menu.name" clearable />
          </el-form-item>
          <el-form-item label="菜单类型" prop="type">
            <el-select v-model="menu.type" placeholder="请选择菜单类型" class="w-full">
              <el-option v-for="(item, key) in menuTypes" :key="key" :value="item.value" :label="item.label" />
            </el-select>
          </el-form-item>
          <!--网页跳转-->
          <el-form-item label="跳转链接" prop="url" :rules="[{ required: true, message: '链接必须填写' }]" v-if="menu.type === 'view'">
            <el-input v-model="menu.url" clearable />
          </el-form-item>
          <!--小程序-->
          <el-form-item label="小程序链接" prop="url" :rules="[{ required: true, message: '链接必须填写' }]" v-if="menu.type === 'miniprogram'">
            <el-input v-model="menu.url" clearable />
          </el-form-item>
          <el-form-item label="小程序appid" prop="appid" :rules="[{ required: true, message: '链接必须填写' }]" v-if="menu.type === 'miniprogram'">
            <el-input v-model="menu.appid" clearable />
          </el-form-item>
          <el-form-item label="小程序页面" prop="pagepath" :rules="[{ required: true, message: '链接必须填写' }]" v-if="menu.type === 'miniprogram'">
            <el-input v-model="menu.pagepath" clearable />
          </el-form-item>
          <!--转客服-->
          <el-form-item label="提示语" prop="pagepath" :rules="[{ required: true, message: '链接必须填写' }]" v-if="menu.type === 'miniprogram'">
            <el-input v-model="menu.pagepath" clearable />
          </el-form-item>
        </el-form>
      </div>
    </div>
    <div class="pb-5">
      <div class="flex justify-end">
        <el-button type="primary" @click="save">保存发布</el-button>
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { Buttons, Menu, Button } from './Menu'
import http from '@/support/http'
const buttons = ref<Buttons>({
  buttons: [
    {
      name: '+',
      type: '',
      sub_buttons: [
        {
          name: '+',
          type: ''
        }
      ]
    }
  ]
})

// active 激活
const isButtonActive = ref<number>(-1)
const isSubButtonActive = ref<number>(-1)

// 默认menu
const menu = ref<Menu>({
  name: '',
  type: ''
})

// 新增 button
const addButton = (button: Button) => {
  if (buttons.value.buttons.length >= 3) {
    if (button.name === '+') {
      button.name = '请输入名称'
    }
    return false
  }
  if (button.name === '+') {
    buttons.value.buttons.unshift({
      name: '请输入名称',
      type: '',
      sub_buttons: [
        {
          name: '+',
          type: ''
        }
      ]
    })
  }
}

// 添加子菜单
const AddSubButton = (subButtons: Array<Menu>) => {
  if (subButtons.length === 5) {
    subButtons.pop()
    subButtons.unshift({
      name: '请输入名称',
      type: ''
    })
    return false
  }
  subButtons.unshift({
    name: '请输入名称',
    type: ''
  })
}

// 选择元素
const selectMenu = (m: any, key: number) => {
  isButtonActive.value = key
  menu.value = m
}
const selecSubtMenu = (m: any, key: number) => {
  isSubButtonActive.value = key
  menu.value = m
}
// 删除菜单 button
const deleteButton = (key: number) => {
  const newButtons: Array<Button> = []

  for (let i = 0; i < buttons.value.buttons.length; i++) {
    if (key !== i) {
      newButtons.push(buttons.value.buttons[i])
    }
  }

  // 当菜单全部删除后初始化
  if (newButtons.length === 0) {
    buttons.value.buttons = []
    newButtons.push({
      name: '+',
      type: '',
      sub_buttons: [
        {
          name: '+',
          type: ''
        }
      ]
    })
  } else {
    let hasPlus = false
    newButtons.forEach(item => {
      if (item.name === '+') {
        hasPlus = true
      }
    })
    if (!hasPlus) {
      newButtons.push({
        name: '+',
        type: '',
        sub_buttons: [
          {
            name: '+',
            type: ''
          }
        ]
      })
    }
  }
  buttons.value.buttons = newButtons
}

// 删除菜单 button
const deleteSubButton = (index: number, key: number) => {
  const newButtons: Array<Menu> = []

  const subButtons = buttons.value.buttons[key].sub_buttons

  for (let i = 0; i < subButtons.length; i++) {
    if (index !== i) {
      newButtons.push(subButtons[i])
    }
  }
  // 当菜单全部删除后初始化
  if (newButtons.length === 0) {
    buttons.value.buttons[key].sub_buttons = []
    newButtons.push({
      name: '+',
      type: ''
    })
  } else {
    let hasPlus = false
    newButtons.forEach(item => {
      if (item.name === '+') {
        hasPlus = true
      }
    })
    if (!hasPlus) {
      newButtons.push({
        name: '+',
        type: ''
      })
    }
  }
  buttons.value.buttons[key].sub_buttons = newButtons
}

// 删除子菜单
// 菜单类型
const menuTypes = ref()
http.get('options/wechatOfficialMenuType').then(r => {
  menuTypes.value = r.data.data
})

const save = () => {
  console.log(buttons.value)
}
</script>
