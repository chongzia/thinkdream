/**
 * Helper 助教函数集合
 */

import Cache from '@/support/cache'
import i18n from '@/i18n'
import moment from 'moment'
const AUTH_TOKEN = 'auth_token'

/**
 * env get
 *
 * @param key
 */
export function env(key: string, defaultValue: any = null): any {
  const env = import.meta.env

  return env[key] ? env[key] : defaultValue
}

/**
 * remember token
 *
 * @param token
 */
export function rememberAuthToken(token: string): void {
  Cache.set(AUTH_TOKEN, token)
}

/**
 * remove auth token
 */
export function removeAuthToken(): void {
  Cache.del(AUTH_TOKEN)
}

/**
 * get auth token
 *
 */
export function getAuthToken(): string | null {
  return Cache.get(AUTH_TOKEN)
}

/**
 * get bearer token
 *
 * @returns
 */
export function getBearerToken(): string | null {
  return 'Bearer ' + getAuthToken()
}

/**
 * 是否是小屏幕
 * @return
 */
export function isMiniScreen(): boolean {
  return window.document.body.clientWidth < 500
}

/**
 * translate
 *
 * @param translate
 * @returns
 */
export function t(translate: string) {
  return i18n.global.t(translate)
}

/**
 * is undefined
 *
 * @param value
 * @returns
 */
export function isUndefined(value: any): boolean {
  return value === undefined
}

/**
 * set page title
 *
 * @param title
 */
export function setPageTitle(title: string) {
  const siteTitle: string = _window('title') ? _window('title') : env('VITE_APP_NAME')

  document.title = !isUndefined(siteTitle) ? title + '-' + siteTitle : title
}

/**
 * is function?
 *
 * @param value
 */
export function isFunction(value: any) {
  return typeof value === 'function'
}

export function _window(key: string) {
  if (window.hasOwnProperty('admin_config')) {
    // @ts-ignore
    return window.admin_config[key]
  }

  return null
}

/**
 * 获取 base url
 *
 * @returns
 */
export function getBaseUrl() {
  const baseUrl = _window('BASE_URL') ? _window('BASE_URL') : env('VITE_BASE_URL')

  const originUrl = `${window.location.origin}/api`

  // 租户模式
  if (isTenancyMode()) {
    return originUrl
  }

  return baseUrl
}

/**
 * 是否是租户模式
 *
 * @returns
 */
export function isTenancyMode() {
  return env('VITE_TENANCY_MODE', false)
}

/**
 * is boolean
 * @param value
 * @returns
 */
export function isBoolean(value: any): boolean {
  return typeof value === 'boolean'
}

/**
 *
 * @param value
 * @returns
 */
export function isNumber(value: any): boolean {
  return typeof value === 'number'
}

/**
 * 首字母大写
 *
 * @param str
 * @returns
 */
export function ucfirst(str: string): string {
  return str[0].toUpperCase() + str.slice(1)
}

/**
 * 首字母小写
 * @param str
 * @returns
 */
export function lcfirst(str: string): string {
  return str[0].toLowerCase() + str.slice(1)
}

/**
 *
 * @param e
 * @returns
 */
export function randomString(e: number = 10): string {
  const t = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678'
  const a = t.length
  let n: string = ''
  for (let i = 0; i < e; i++) {
    n += t.charAt(Math.floor(Math.random() * a))
  }
  return n
}

/**
 * 生成唯一的文件名称
 * @param filename
 * @returns
 */
export function generateFilename(filename: string) {
  const ext = filename.split('.')
  ext.shift()
  const timestamp = Date.now()
  return timestamp + randomString() + '.' + ext.join('.')
}

/**
 * 数组去重
 * @param arr
 * @returns
 */
export function unique(arr: Array<any>) {
  return Array.from(new Set(arr))
}

/**
 * 是否是生产环境
 * @returns
 */
export function isProd() {
  return import.meta.env?.PROD === true
}

// 获取文件 ext
export const getFileExt = (filename: string): string => {
  return filename.substring(filename.lastIndexOf('.')).toLowerCase()
}

// 获取文件名
export const getFilename = (filename: string): string => {
  return filename.substring(filename.lastIndexOf('/') + 1)
}

// date 函数
export const date = (format: string, timestamp: number): string => {
  return moment(timestamp * 1000).format(format)
}

/**
 * 由于是前后端分离，所以必须使用加上 http://host 才能显示
 *
 * 如果前后端项目是同一个域名 则不需要
 */
export const warpHost = (path: string | null) => {
  if (!path) {
    return path
  }

  if (path.indexOf('http://') > -1 || path.indexOf('https://') > -1) {
    return path
  }

  const serverURL: string = (getBaseUrl() as string).replace('/api', '').trim()

  const currentHost = location.protocol + '//' + location.host
  console.log(currentHost, serverURL)
  if (serverURL.indexOf(currentHost) < 0) {
    return serverURL + path
  }

  return path
}

/**
 * 字符串转换成函数
 *
 * @param str
 * @returns
 */
export const strToFunction = (str: string, params?: any) => {
  if (params) {
    return new Function('return ' + str)(params)
  }

  return new Function('return ' + str)()
}
