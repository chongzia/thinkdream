<!-- .vitepress/theme/components/ApiExample.vue -->
<template>
    <div class="api-example">
        <h3>Example</h3>
        <div class="language">{{ language }}</div>
        <pre><code>{{ code }}</code></pre>
    </div>
</template>

<script>
export default {
    props: {
        language: {
            type: String,
            required: true,
        },
        code: {
            type: String,
            required: true,
        },
    },
};
</script>

<style scoped>
.api-example {
    margin-bottom: 2rem;
}

.language {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

pre {
    background-color: #f4f4f4;
    padding: 1rem;
    border-radius: 4px;
    overflow-x: auto;
}

code {
    font-family: monospace;
}
</style>
