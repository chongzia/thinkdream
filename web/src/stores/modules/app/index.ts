import { defineStore } from 'pinia'
import Cache from '@/support/cache'
import http from '@/support/http'
import { isUndefined } from '@/support/helper'

interface exceptions {
  message: string
  trace: Array<object>
}

interface setting {
  dashboard: {
    name: string
    logo: string
  }

  login: {
    wechat: number
    mobile: number
    use_captcha: number // 是否开启验证码
  }
}
/**
 * app
 */
type app = {
  size: 'small' | 'medium' | 'large'

  isExpand: boolean

  locale: 'zh' | 'en' | string

  language: string

  isMobile: boolean

  isDarkMode: boolean

  activeMenu: string

  isExceptionShow: boolean

  exceptions: exceptions

  serverPrint: string

  is_vertical: boolean

  setting: setting
}

export const useAppStore = defineStore('app', {
  state: (): app => ({
    size: 'small',
    isExpand: true,
    locale: Cache.get('language') || 'zh',
    language: Cache.get('language') || 'zh', // 当前语言
    isMobile: false,
    isDarkMode: false,
    activeMenu: '/dashboard',
    isExceptionShow: false,
    exceptions: {
      message: '',
      trace: []
    },
    serverPrint: '',
    is_vertical: false,
    setting: {
      dashboard: {
        name: '管理后台',
        logo: ''
      },

      login: {
        wechat: 0,
        mobile: 0,
        use_captcha: 0 // 是否开启验证码
      }
    }
  }),

  getters: {
    getSize(): string {
      return this.size
    },

    getLocale(): string {
      return this.locale
    },

    getLanguage(): string {
      return this.language
    },

    getIsMobile(): boolean {
      return this.isMobile
    },

    getIsDarkMode(): boolean {
      return this.isDarkMode
    },

    getActiveMenu(): string {
      return this.activeMenu
    },

    getExceptionShow(): boolean {
      return this.isExceptionShow
    },

    getExceptionTrace(): object | null {
      return this.exceptions
    },

    getServerPring(): string {
      return this.serverPrint
    },

    getVertical(): boolean {
      return this.is_vertical
    },

    getSetting(): setting {
      return this.setting
    }
  },

  actions: {
    changeSize(size: 'small' | 'medium' | 'large'): void {
      this.size = size
    },

    /**
     * 更新语言设置
     * @param locale 语言代码
     */
    changeLocale(locale: string): void {
      Cache.set('language', locale)
      this.locale = locale
      this.language = locale

      // 加载语言包
      import('@/i18n').then(({ default: i18n }) => {
        i18n.loadLanguage(locale)
      })

      // 触发语言变化事件，使其他组件可以响应
      document.dispatchEvent(new CustomEvent('language-changed', { detail: { lang: locale } }))
    },

    changeExpaned(): void {
      this.isExpand = !this.isExpand
    },

    setDarkMode(isDarkMode: boolean): void {
      this.isDarkMode = isDarkMode
    },

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * 设置当前激活的菜单
     * @param activeMenu
     */
    /*******  88203f34-0ad6-47e3-9a9b-a31dfd5d2f3f  *******/
    setActiveMenu(activeMenu: string): void {
      this.activeMenu = activeMenu.startsWith('/') ? activeMenu : '/' + activeMenu
    },

    setIsExceptionShow(show: boolean, exceptions: exceptions, serverPrint: string): void {
      this.isExceptionShow = show
      this.exceptions = exceptions
      this.serverPrint = serverPrint
    },

    setVertical(isVertical = false) {
      this.is_vertical = isVertical
    },

    setSetting() {
      http.get('setting/config').then(r => {
        if (!isUndefined(r.data.data.dashboard)) {
          this.setting = r.data.data
        }
      })
    }
  }
})
