import '@/styles/index.scss'

import CatchAdmin from './support/catchAdmin'
import Cache from './support/cache'

// 在应用启动前先清理无效的localStorage数据，防止浏览器扩展报错
Cache.cleanInvalidCache()

const admin = new CatchAdmin()
admin.bootstrap()
