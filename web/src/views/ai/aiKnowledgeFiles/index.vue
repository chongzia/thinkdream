<template>
  <div>
    <catch-table :columns="columns" :api="api" :operation="false">
      <template #dialog="row">
        <Create :primary="row?.id" :api="api" />
      </template>
      <template #operation>
        <Add text="导入文件" @click="uploadFilesVisibe = true" />
      </template>
    </catch-table>

    <Dialog v-model="uploadFilesVisibe" title="导入文件" destroy-on-close>
      <div class="flex items-center justify-center">
        <UploadFiles v-model="files" :file-extensions="['.md', '.txt', '.csv', '.xlsx']" />
      </div>
      <div class="flex justify-end mt-4">
        <el-button type="primary" @click="importFiles">导入</el-button>
      </div>
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import Create from './form/create.vue'
import UploadFiles from '@/components/admin/upload/UploadFiles.vue'
import Message from '@/support/message'
import http from '@/support/http'
const api = 'ai/knowledge/files'
const uploadFilesVisibe = ref(false)
const files = ref([])
const importFiles = () => {
  if (files.value.length === 0) {
    Message.error('请先上传导入得文件')
  } else {
    http.post('').then(r => {
      Message.success('导入成功')
    })
  }
}
// table columns
const columns = [
  {
    prop: 'id',
    label: 'id',
    width: 100
  },
  {
    prop: 'content',
    label: '文件内容'
  },
  {
    prop: 'embedding_content',
    label: '向量内容'
  },
  {
    prop: 'created_at',
    label: '创建时间'
  },
  {
    prop: 'updated_at',
    label: '更新时间'
  },
  {
    type: 'operate',
    label: '操作'
  }
]
// table search
</script>
