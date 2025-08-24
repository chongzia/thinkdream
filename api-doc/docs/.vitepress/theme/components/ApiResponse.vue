<template>
    <div class="p-2 mt-5 border border-gray-200 rounded border-1">
        <div class="flex justify-between p-2 border-b border-gray-200">
            <div class="text-2xl">🖨️ 响应数据</div>
            <div class="p-2 text-indigo-600 rounded-md">application/json</div>
        </div>
        <div class="overflow-x-auto">
            <table v-if="params.length" class="min-w-full border-collapse">
                <thead>
                    <tr>
                        <th>参数</th>
                        <th>类型</th>
                        <th>描述</th>
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
                    </tr>
                </tbody>
            </table>

            <div v-else class="p-2">暂无数据</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
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
.content table {
    width: 100%;
    border-collapse: collapse;
}
.content table th,
.content table td {
    border: 1px solid #eaecef;
    text-align: left;
    width: 300px;
}
</style>
