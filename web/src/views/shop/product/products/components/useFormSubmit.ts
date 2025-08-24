import { ref } from 'vue'
import type { FormInstance } from 'element-plus'
export function useFormSubmit(next: Function|null) {
  const form = ref<FormInstance>()
  const submitForm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return
    await formEl.validate((valid, fields) => {
      if (valid) {
        next?.()
      }
    })
  }
  const submit = () => {
    submitForm(form.value)
  }

  return { form, submit }
}
