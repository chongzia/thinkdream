<template>
    <div class="w-full p-2 mt-5 border border-gray-200 rounded border-1">
        <div class="flex justify-between p-2 border-b border-gray-200">
            <div class="text-xl">✨️ 请求头信息</div>
        </div>
        <div class="overflow-x-auto">
            <table v-if="headers.length" class="w-full border-collapse">
                <thead class="min-w-full border-collapse">
                    <tr>
                        <th>键</th>
                        <th>值</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="param in headers" :key="param.key">
                        <td>
                            <code>{{ param.key }}</code>
                        </td>
                        <td>
                            <code>{{ param.value }}</code>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        headers: {
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
    width: 500px;
}
</style>
