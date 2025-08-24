import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router'
import type { App } from 'vue'
import { isProd } from '@/support/helper'
// module routers
// import { getModuleViewComponents } from './constantRoutes'

const notInProdRoute = () => {
  if (isProd()) {
    return [] as RouteRecordRaw[]
  } else {
    return [
      {
        path: '/develop',
        name: 'develop',
        component: () => import('@/layout/index.vue'),
        meta: { title: '开发工具', icon: 'wrench-screwdriver' },
        children: [
          {
            path: 'modules',
            name: 'modules',
            meta: { title: '模块管理' },
            component: () => import('@/views/develop/module/index.vue')
          },
          {
            path: 'schemas',
            name: 'schemas',
            meta: { title: 'Schemas' },
            component: () => import('@/views/develop/schema/index.vue')
          },
          {
            path: 'generate/:schema',
            name: 'generate',
            meta: { title: '代码生成', hidden: true, active_menu: '/develop/schemas' },
            component: () => import('@/views/develop/generate/index.vue')
          }
        ]
      },
      {
        path: '/components',
        component: () => import('@/layout/index.vue'),
        name: 'component_show',
        meta: { title: '组件演示', icon: 'wrench-screwdriver' },
        children: [
          {
            path: 'button',
            name: 'button',
            meta: { title: '小组件' },
            component: () => import('@/views/components/button/index.vue')
          },
          {
            path: 'icons',
            name: 'icons',
            meta: { title: '图标' },
            component: () => import('@/views/components/icons/index.vue')
          },
          {
            path: 'uploads',
            name: 'uploads',
            meta: { title: '上传' },
            component: () => import('@/views/components/uploads/index.vue')
          },
          {
            path: 'editor',
            name: 'editor',
            meta: { title: '编辑器' },
            component: () => import('@/views/components/editor/index.vue')
          },
          {
            path: 'print',
            name: 'print',
            meta: { title: '异常打印' },
            component: () => import('@/views/components/print/index.vue')
          },
          {
            path: 'remote',
            name: 'remote',
            meta: { title: '远程组件' },
            component: () => import('@/views/components/remote/index.vue')
          }
        ]
      },
      {
        path: '/dymaic',
        component: () => import('@/layout/index.vue'),
        name: 'dymaic_form',
        meta: { title: '动态表单', icon: 'wrench-screwdriver' },
        children: [
          {
            path: 'permission',
            name: 'permission',
            meta: { title: '权限表单' },
            component: () => import('@/views/components/dymaic/permission/index.vue')
          },
          {
            path: 'role',
            name: 'role',
            meta: { title: '角色表' },
            component: () => import('@/views/components/dymaic/role/index.vue')
          }
        ]
      }
    ] as RouteRecordRaw[]
  }
}
// 动态加载模版
// getModuleViewComponents()
export const constantRoutes: RouteRecordRaw[] = [
  {
    path: '/dashboard',
    name: 'dashboard',
    meta: { title: 'DashBoard', icon: 'home' },
    component: () => import('@/layout/index.vue'),
    children: [
      {
        path: 'basic',
        name: 'basic',
        meta: { title: '基础', hidden: false },
        component: () => import('@/views/dashboard/server/index.vue')
      },
      {
        path: 'sales',
        name: 'sales',
        meta: { title: '销量', hidden: false },
        component: () => import('@/views/dashboard/sales/index.vue')
      }
    ]
  }
].concat(notInProdRoute() as any)

// default routes, it will not change to menus
const defaultRoutes: RouteRecordRaw[] = [
  {
    path: '/',
    name: '/',
    component: () => import('@/layout/index.vue'),
    redirect: '/dashboard/basic',
    children: [
      {
        path: '/404',
        name: '404',
        meta: { title: '404' },
        component: () => import('@/components/404/index.vue')
      }
    ]
  },
  {
    path: '/users',
    component: () => import('@/layout/index.vue'),
    children: [
      {
        path: 'center',
        name: 'user-center',
        meta: { title: '个人中心' },
        component: () => import('@/views/user/center.vue')
      }
    ]
  },
  {
    path: '/system',
    component: () => import('@/layout/index.vue'),
    children: [
      {
        path: 'setting',
        name: 'system-setting',
        meta: { title: '系统设置' },
        component: () => import('@/views/system/basic/index.vue')
      }
    ]
  },
  {
    path: '/ticket',
    component: () => import('@/layout/index.vue'),
    children: [
      {
        path: 'templates',
        name: 'ticket-templates',
        meta: { title: '工单模板管理' },
        component: () => import('@/views/tickets/ticketTemplates/index.vue')
      }
    ]
  },
  {
    path: '/tickets',
    component: () => import('@/layout/index.vue'),
    children: [
      {
        path: 'detail/:id',
        name: 'ticket-detail',
        meta: { title: '工单详情' },
        component: () => import('@/views/tickets/tickets/index.vue')
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    meta: { title: '登录' },
    component: () => import('@/views/login/index.vue')
  }
]

const routes = constantRoutes.concat(defaultRoutes)
const router = createRouter({
  history: createWebHashHistory(),
  routes,
  // 路由滚动
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { top: 0, behavior: 'smooth' }
  }
})

export function bootstrapRouter(app: App) {
  app.use(router)
}

export default router
