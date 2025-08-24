<!-- .vitepress/theme/components/ApiEndpoint.vue -->
<template>
    <div
        class="flex flex-row items-center p-2 mt-5 space-x-4 rounded bg-slate-100"
    >
        <div
            class="px-2 py-1 mr-2 text-sm text-white rounded"
            :class="method.toLowerCase()"
        >
            {{ method }}
        </div>
        <div class="cursor-pointer hover:border-collapse path hover:border-b">
            /{{ path }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        method: {
            type: String,
            required: true,
        },
        path: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            default: "",
        },
    },
};
</script>

<style scoped>
.api-endpoint {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.get {
    @apply bg-green-600;
}
.post {
    background-color: #f97316;
}
.put {
    background-color: #fca130;
}
.delete {
    background-color: #f93e3e;
}
.patch {
    background-color: #5c50e3;
}

.path {
    font-weight: bold;
    margin-right: 0.5rem;
}
</style>
