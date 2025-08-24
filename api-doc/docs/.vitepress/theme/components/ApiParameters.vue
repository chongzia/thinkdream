<template>
    <div class="p-2 mt-5 border border-gray-200 rounded border-1">
        <div class="flex justify-between p-2 border-b border-gray-200">
            <div class="text-xl">
                {{
                    type === 1
                        ? "📲 Body "
                        : type === 2
                        ? "📤️ Query "
                        : "🔌 Path "
                }}
                参数
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr>
                        <th>参数</th>
                        <th>类型</th>
                        <th>描述</th>
                        <th>✂️</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="param in params" :key="param.name">
                        <td>
                            <code>{{ param.name }}</code>
                        </td>
                        <td>
                            <code>{{ param.type }}</code>
                        </td>
                        <td>{{ param.description }}</td>
                        <td :class="param.required ? 'text-red-500' : ''">
                            <div
                                class="flex justify-center w-10 py-0.5 px-1 text-[12px] text-white bg-rose-500 rounded"
                                v-if="param.required"
                            >
                                必 填
                            </div>
                            <div
                                v-else
                                class="flex justify-center w-10 py-0.5 px-1 text-[12px] bg-zinc-200 rounded text-gray-600"
                            >
                                可 选
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "BodyParams",
    props: {
        type: {
            type: Number,
            required: true,
            default: 1,
        },
        params: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style scoped>
.header {
    border-bottom: 1px solid #eaecef;
}
.content {
    overflow-x: auto;
}
.content table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
}
.content table th,
.content table td {
    border: 1px solid #eaecef;
    text-align: left;
    @apply w-1/3 !important;
}
</style>
