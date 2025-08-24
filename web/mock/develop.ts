import { MockMethod } from 'vite-plugin-mock'

export default [
  {
    url: '/api/module',
    method: 'get',
    response: ({ query }) => {
      return {
        code: 10000,
        message: 'success',
        data: [
          {
            title: '权限管理',
            name: 'permissions',
            path: 'permissions',
            keywords: '权限, 角色, 部门',
            description: '权限管理模块',
            provider: '\\Modules\\Permissions\\Providers\\PermissionsServiceProvider',
            version: '1.0.0',
            enable: true
          },
          {
            title: '内容管理',
            path: 'Cms',
            keywords: 'cms,内容管理',
            description: '内容管理系统',
            name: 'cms',
            provider: '\\Modules\\Cms\\Providers\\CmsServiceProvider',
            version: '1.0.0',
            enable: true
          }
        ]
      }
    }
  },

  {
    url: '/api/schema',
    method: 'get',
    response: ({ query }) => {
      return {
        code: 10000,
        messsage: 'success',
        data: [
          {
            id: 14,
            module: 'cms',
            name: 'cms_resources',
            columns: 'id,name,content,url,description,type,is_visible',
            is_soft_delete: 1,
            created_at: '2023-03-06 08:40',
            updated_at: '2023-03-06 08:40'
          }
        ]
      }
    }
  }
] as MockMethod[]
