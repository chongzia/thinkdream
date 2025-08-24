import Cache from '@/support/cache'
import { createI18n } from 'vue-i18n'
import type { App } from 'vue'
import http from '@/support/http'

// 语言包缓存的键名
const LANG_CACHE_KEY = 'cached_lang_pack_'

// 创建i18n实例
const i18n = createI18n({
  locale: Cache.get('language') || 'zh',
  fallbackLocale: 'zh',
  globalInjection: true,
  legacy: false,
  messages: {} // 初始化为空对象，语言包将从后端加载
})

// 扩展 i18n 类型
declare module 'vue-i18n' {
  interface I18n {
    loadLanguage: (lang: string) => Promise<boolean>
  }
}

/**
 * 从后端加载语言包
 * @param locale 语言代码
 * @returns Promise<boolean> 加载是否成功
 */
const loadTranslations = async (locale: string): Promise<boolean> => {
  // 如果没有缓存，从后端获取语言包
  try {
    const response = await http.get(`/lang/${locale}`)

    if (response.data && response.data.data) {
      // 设置语言包
      i18n.global.setLocaleMessage(locale, response.data.data)

      // 更新当前语言
      i18n.global.locale.value = locale

      // 保存语言设置到缓存
      Cache.set('language', locale)

      // 缓存语言包数据
      Cache.set(`${LANG_CACHE_KEY}${locale}`, response.data.data)

      return true
    }
    return false
  } catch (error) {
    // 如果是默认语言且没有缓存，则失败
    if (locale === 'zh') {
      return false
    }
    return loadTranslations('zh')
  }
}

// 将 loadLanguage 方法挂载到 i18n 对象上
i18n.loadLanguage = loadTranslations

/**
 * 初始化i18n
 * @param app Vue应用实例
 */
export async function bootstrapI18n(app: App): Promise<void> {
  // 加载默认语言包
  const defaultLocale = Cache.get('language') || 'zh'

  try {
    // 尝试加载默认语言包
    const success = await loadTranslations(defaultLocale)

    // 如果默认语言加载失败且不是中文，尝试加载中文
    if (!success && defaultLocale !== 'zh') {
      await loadTranslations('zh')
    }
  } catch (error) {
    // 如果加载失败，创建一个空的语言包以避免应用崩溃
    i18n.global.setLocaleMessage('zh', {})
    i18n.global.locale.value = 'zh'
  }

  // 注册i18n插件
  app.use(i18n)
}

export default i18n
