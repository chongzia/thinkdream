/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./docs/.vitepress/**/*.{js,ts,vue}",
        "./docs/.vitepress/theme/**/*.{js,ts,vue}",
        "./docs/api/**/*.{js,ts,vue,md}",
        "./docs/**/*.{js,ts,vue,md}",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
