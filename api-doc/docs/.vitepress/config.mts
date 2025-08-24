import { defineConfig } from "vitepress";
import sider from "./siders/sider";

const sides =[{text: '介绍', link: '/docs/api/intro'}].concat(sider)

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "专业版接口文档",
    lang: "zh-cn",
    description: "专业版接口文档",
    head: [["link", { rel: "icon", href: "/favicon.ico" }]],
    rewrites: {
        "api/(.*)": "docs/api/(.*)",

    },
    sitemap: {
        hostname: "https://api-docs.catchadmin.com/",
    },
    cleanUrls: true,
    themeConfig: {
        logo: "/logomark.min.svg",
        // https://vitepress.dev/reference/default-theme-config
        nav: [
            {
                text: "专业版",
                link: "https://catchadmin.com/pro",
            }
        ],
        sidebar: {
            // laravel 11
            "/docs/api/": sides
        },
        returnToTopLabel: "回到顶部",
        sidebarMenuLabel: "菜单",
        darkModeSwitchLabel: "主题",
        lightModeSwitchTitle: "切换到浅色模式",
        darkModeSwitchTitle: "切换到深色模式",
        docFooter: {
            prev: "上一页",
            next: "下一页",
        },
        outline: {
            level: "deep",
            label: "页面导航",
        },
        search: {
            provider: "local",
        },
    },
});
