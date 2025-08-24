<template>
  <catch-form :config="config" :beforeSubmit="beforeSubmit" />
</template>
<script lang="ts" setup>
// @ts-nocheck
defineProps({
  config: Object
})

const beforeSubmit = formData => {
  formData.parent_id = formData.parent_id ? formData.parent_id[formData.parent_id.length - 1] : 0
  return formData
}
</script>
