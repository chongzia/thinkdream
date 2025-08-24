export default class Cache {
  private static readonly prefix:string = 'catchadmin_'
  /**
     * set
     *
     * @param key
     * @param value
     */
  static set (key:string, value: any) : void {
    // 如果是对象，转换为JSON字符串存储
    const storageValue = typeof value === 'object' && value !== null 
      ? JSON.stringify(value) 
      : value
    window.localStorage.setItem(Cache.prefix + key, storageValue)
  }

  /**
     * get
     *
     * @param key
     * @returns
     */
  static get (key: string) : any {
    const value = window.localStorage.getItem(Cache.prefix + key)
    if (value === null) {
      return null
    }
    
    // 尝试解析JSON，如果失败则返回原始字符串
    try {
      return JSON.parse(value)
    } catch {
      return value
    }
  }

  /**
     * delete
     *
     * @param key
     * @returns
     */
  static del (key: string) : void {
    window.localStorage.removeItem(Cache.prefix + key)
  }

  /**
   * 清理无效的缓存数据
   * 移除所有无效的缓存项（包括"[object Object]"和无法解析的JSON）
   */
  static cleanInvalidCache() : void {
    const keysToRemove: string[] = []
    
    // 清理所有localStorage中的无效数据（不仅仅是我们的prefix）
    for (let i = 0; i < window.localStorage.length; i++) {
      const key = window.localStorage.key(i)
      if (key) {
        const value = window.localStorage.getItem(key)
        if (value === '[object Object]' || value === 'undefined' || value === 'null') {
          keysToRemove.push(key)
        } else if ((value && value.startsWith('{')) || (value && value.startsWith('['))) {
          // 尝试解析看起来像JSON的字符串
          try {
            JSON.parse(value)
          } catch {
            // 如果无法解析且不是我们的业务数据，则清理
            if (key.startsWith(Cache.prefix) || value === '[object Object]') {
              keysToRemove.push(key)
            }
          }
        }
      }
    }
    
    keysToRemove.forEach(key => {
      try {
        window.localStorage.removeItem(key)
      } catch (error) {
        console.warn(`无法移除缓存项 ${key}:`, error)
      }
    })
    
    if (keysToRemove.length > 0) {
      console.log(`已清理 ${keysToRemove.length} 个无效缓存项:`, keysToRemove)
    }
  }
}
