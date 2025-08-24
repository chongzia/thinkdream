import { defineStore } from 'pinia'
import { Permission } from '@/types/Permission'
import { MenuType } from '@/enum/app'
import { Menu } from '@/types/Menu'
import { constantRoutes } from '@/router'
import { RouteRecordRaw } from 'vue-router'
import { toRaw } from 'vue'
import { getModuleViewComponents } from '@/router/constantRoutes'
import { useAppStore } from '@/stores/modules/app'

interface Permissions {
  menus: Menu[]

  asyncMenus: Menu[]

  permissions: Permission[]

  menuPathMap: Map<string, string>

  vertical_active_menu_name: string
}
export const usePermissionsStore = defineStore('PermissionsStore', {
  state: (): Permissions => {
    return {
      menus: [],

      asyncMenus: [],

      permissions: [],

      menuPathMap: new Map(),

      vertical_active_menu_name: 'dashboard'
    }
  },

  /**
   * get
   */
  getters: {
    getMenus(): Menu[] {
      return this.menus
    },

    getAsyncMenus(): Menu[] {
      return this.asyncMenus
    },

    getPermissions(): Permission[] {
      return this.permissions
    },

    getMenuPathMap(): Map<string, string> {
      return this.menuPathMap
    },

    getVerticalActiveMenuName(): string {
      return this.vertical_active_menu_name
    }
  },

  /**
   * actions
   */
  actions: {
    /**
     * generate async menus
     * @param permissions
     * @param force
     * @returns
     */
    getAsyncMenusFrom(permissions: Permission[], force: boolean = false): Menu[] {
      // 如果非强制获取并且 menu 有值，直接返回
      if (!force && this.asyncMenus.length > 0) {
        return this.asyncMenus
      }

      const menus: Permission[] = []

      permissions.forEach(permission => {
        if (permission.type === MenuType.PAGE_TYPE || permission.type === MenuType.TOP_TYPE) {
          menus.push(permission)
        }

        // set map
        this.menuPathMap.set(permission.route, permission.permission_name)
      })

      this.setAsyncMenus(this.getAsnycMenus(menus, 0, '', getModuleViewComponents()))

      return this.asyncMenus
    },

    /**
     * get menus
     * @param permissions
     * @param force
     * @returns
     */
    getMenusFrom(permissions: Permission[], force: boolean = false): Menu[] {
      // 如果非强制获取并且 menu 有值，直接返回
      if (!force && this.menus.length > 0) {
        return this.menus
      }
      const asyncMenus = this.getAsyncMenusFrom(permissions, force)

      this.setMenus(toRaw(asyncMenus))

      const appStore = useAppStore()
      // 如果是水平模式，则获取点击菜单的子菜单
      if (appStore.getVertical) {
        const len = this.menus.length
        for (let i = 0; i < len; i++) {
          if (this.menus[i].name === this.getVerticalActiveMenuName) {
            // @ts-ignore
            return this.menus[i].children
          }
        }
      }
      return this.menus
    },

    /**
     * set menus
     *
     * @param menus
     */
    setMenus(menus: Menu[]) {
      this.menus = this.transformRoutesToMenus(constantRoutes).concat(menus)
    },

    setAsyncMenus(menus: Menu[]) {
      this.asyncMenus = menus
    },

    /**
     * 设置 vertical 模式的激活菜单
     *
     * @param name
     */
    setVerticalActiveMenuName(name: string) {
      this.vertical_active_menu_name = name
    },

    /**
     * 生成 Menus
     *
     * @param permissions
     * @param parentId
     * @param path
     * @param viewComponents
     * @returns
     */
    getAsnycMenus(permissions: Permission[], parentId: number = 0, path: string = '', viewComponents: any): Menu[] {
      const menus: Menu[] = []
      permissions.forEach(permission => {
        if (permission.parent_id === parentId) {
          // menu
          let importComponent
          if (permission.type === MenuType.TOP_TYPE) {
            importComponent = () => import('@/layout/index.vue')
          } else {
            importComponent = viewComponents.get(permission.component)
          }
          const menu: Menu = Object.assign({
            path: this.resolveRoutePathRoutePath(permission.route, path),
            name: permission.module + '_' + permission.permission_mark + permission.route.replace('/', '_'),
            component: importComponent,
            redirect: permission.redirect,
            meta: Object.assign({ title: permission.permission_name, icon: permission.icon, keepalive: permission.keepalive, hidden: permission.hidden, active_menu: permission.active_menu })
          })

          // child menu
          const children = this.getAsnycMenus(permissions, permission.id, menu.path, viewComponents)
          if (children.length > 0) {
            menu.children = children
          }
          menus.push(menu)
        }
      })

      return menus
    },

    /**
     * transform routes to menus
     * @param routes
     * @param path
     * @returns
     */
    transformRoutesToMenus(routes: Menu[] | Array<RouteRecordRaw>, path: string = ''): Menu[] {
      const menus: Menu[] = []

      routes.forEach(route => {
        if (route.meta?.hidden) {
          return false
        }

        const menu: Menu = Object.assign({
          path: this.resolveRoutePathRoutePath(route.path, path),
          name: route.name,
          meta: route.meta,
          component: route.component
        })

        if (route.children?.length) {
          menu.children = this.transformRoutesToMenus(route.children, menu.path)
        }

        menus.push(menu)
      })
      return menus
    },

    /**
     * resolve path
     * @param route
     * @param path
     * @returns
     */
    resolveRoutePathRoutePath(route: string, path: string): string {
      if (path.length) {
        return (path + (!route.startsWith('/') ? '/' : '') + route).replace(/\/$/g, '')
      }

      // 去除尾部的 /
      return route.replace(/\/$/g, '')
    }
  }
})
