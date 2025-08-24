import type { FormInstance } from 'element-plus'
import { ref } from 'vue'
import http from '@/support/http'
import Message from '@/support/message'

export const submit = (formData: any) => {
  const form = ref<FormInstance>()
  const submitForm = (form: FormInstance | undefined) => {
    if (!form) return
    form.validate((valid, fields) => {
      if (valid) {
        http.post('/system/connector/config', formData).then(r => {
          if (r.data.code === 10000) {
            Message.success('配置成功')
          }
        })
      }
    })
  }

  const init = async (formData: any, prefix: string) => {
    await http.get('/system/connector/config', { prefix }).then(r => {
      const data = r.data.data
      if (typeof data === 'object') {
        formData.value[prefix] = Object.assign(formData.value[prefix], r.data.data)
      }
    })
  }

  return { form, submitForm, init }
}
