import { MockMethod } from 'vite-plugin-mock'

export default [
  {
    url: '/api/permissions/roles',
    method: 'get',
    response: ({ query }) => {
      return {
        code: 10000,
        message: 'success',
        data: [
          {
            id: 1,
            role_name: '测试',
            identify: 'test',
            parent_id: 0,
            description: null,
            data_range: 3,
            creator_id: 1,
            created_at: '2023-03-07 06:32',
            updated_at: '2023-03-07 06:32',
            creator: 'catchadmin',
            permissions: [
              {
                id: 1
              },
              {
                id: 13
              },
              {
                id: 14
              },
              {
                id: 15
              },
              {
                id: 16
              },
              {
                id: 17
              },
              {
                id: 18
              },
              {
                id: 2
              },
              {
                id: 21
              },
              {
                id: 22
              },
              {
                id: 23
              },
              {
                id: 24
              },
              {
                id: 25
              },
              {
                id: 26
              },
              {
                id: 27
              },
              {
                id: 28
              },
              {
                id: 3
              },
              {
                id: 4
              },
              {
                id: 5
              },
              {
                id: 6
              },
              {
                id: 7
              },
              {
                id: 8
              },
              {
                id: 9
              }
            ]
          }
        ]
      }
    }
  },
  {
    url: '/api/permissions/roles',
    method: 'get',
    response: ({ query }) => {
      return {
        code: 10000,
        message: 'success',
        data: [
          {
            id: 1,
            job_name: '开发岗位',
            coding: null,
            status: 1,
            sort: 1,
            description: null,
            creator_id: 1,
            created_at: '2023-03-14 01:46',
            updated_at: '2023-03-14 01:46',
            creator: 'catchadmin'
          }
        ]
      }
    }
  },
  {
    url: '/api/permissions/departments',
    method: 'get',
    response: ({ query }) => {
      return {
        code: 10000,
        message: 'success',
        data: [
          {
            id: 1,
            parent_id: 0,
            department_name: '总部',
            principal: null,
            mobile: null,
            email: null,
            status: 1,
            sort: 1,
            creator_id: 1,
            created_at: '2023-03-14 01:47',
            updated_at: '2023-03-14 01:47',
            creator: 'catchadmin',
            children: [
              {
                id: 3,
                parent_id: 1,
                department_name: '南京部门',
                principal: null,
                mobile: null,
                email: null,
                status: 1,
                sort: 1,
                creator_id: 1,
                created_at: '2023-03-14 01:47',
                updated_at: '2023-03-14 01:47',
                creator: 'catchadmin'
              },
              {
                id: 2,
                parent_id: 1,
                department_name: '北京部门',
                principal: null,
                mobile: null,
                email: null,
                status: 1,
                sort: 1,
                creator_id: 1,
                created_at: '2023-03-14 01:47',
                updated_at: '2023-03-14 01:47',
                creator: 'catchadmin'
              }
            ]
          }
        ]
      }
    }
  },
  {
    url: '/api/permissions/permissions',
    method: 'get',
    response: ({ query }) => {
      return {
        code: 10000,
        message: 'success',
        data: [
          {
            id: 1,
            parent_id: 0,
            permission_name: '权限管理',
            route: '/permission',
            icon: 'arrow-down-on-square-stack',
            module: 'permissions',
            permission_mark: '',
            component: '/admin/layout/index.vue',
            redirect: null,
            keepalive: 1,
            type: 1,
            hidden: 1,
            sort: 1,
            active_menu: '',
            creator_id: 0,
            created_at: '2022-12-09 09:58',
            updated_at: '2023-01-04 02:08',
            creator: null,
            children: [
              {
                id: 2,
                parent_id: 1,
                permission_name: '角色管理',
                route: 'roles',
                icon: 'arrow-left-circle',
                module: 'permissions',
                permission_mark: 'Roles',
                component: '/Permissions/views/roles/index.vue',
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 6,
                active_menu: '',
                creator_id: 0,
                created_at: '2022-12-09 09:59',
                updated_at: '2023-01-04 02:08',
                creator: null,
                actions: [
                  {
                    id: 3,
                    parent_id: 2,
                    permission_name: '列表',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Roles@index',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 09:00',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 4,
                    parent_id: 2,
                    permission_name: '新增',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Roles@store',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 2,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 09:00',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 5,
                    parent_id: 2,
                    permission_name: '读取',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Roles@show',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 3,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 09:00',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 6,
                    parent_id: 2,
                    permission_name: '更新',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Roles@update',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 4,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 09:00',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 7,
                    parent_id: 2,
                    permission_name: '删除',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Roles@destroy',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 5,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 09:00',
                    updated_at: '2023-01-04 02:08'
                  }
                ]
              },
              {
                id: 22,
                parent_id: 1,
                permission_name: '部门管理',
                route: 'departments',
                icon: 'table-cells',
                module: 'permissions',
                permission_mark: 'Departments',
                component: '/Permissions/views/departments/index.vue',
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 1,
                active_menu: '',
                creator_id: 0,
                created_at: '2022-12-10 03:03',
                updated_at: '2023-02-23 01:58',
                creator: null,
                actions: [
                  {
                    id: 23,
                    parent_id: 22,
                    permission_name: '列表',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Departments@index',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 02:04',
                    updated_at: '2023-02-23 01:58'
                  },
                  {
                    id: 24,
                    parent_id: 22,
                    permission_name: '新增',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Departments@store',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 02:04',
                    updated_at: '2023-02-23 01:58'
                  },
                  {
                    id: 25,
                    parent_id: 22,
                    permission_name: '读取',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Departments@show',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 02:04',
                    updated_at: '2023-02-23 01:58'
                  },
                  {
                    id: 26,
                    parent_id: 22,
                    permission_name: '更新',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Departments@update',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 06:21',
                    updated_at: '2023-02-23 01:58'
                  },
                  {
                    id: 27,
                    parent_id: 22,
                    permission_name: '删除',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Departments@destroy',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 06:22',
                    updated_at: '2023-02-23 01:58'
                  },
                  {
                    id: 28,
                    parent_id: 22,
                    permission_name: '禁用/启用',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Departments@enable',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 6,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:21',
                    updated_at: '2023-02-23 01:58'
                  }
                ]
              },
              {
                id: 15,
                parent_id: 1,
                permission_name: '岗位管理',
                route: 'jobs',
                icon: 'globe-americas',
                module: 'permissions',
                permission_mark: 'Jobs',
                component: '/permission/jobs/index.vue',
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 1,
                active_menu: '',
                creator_id: 0,
                created_at: '2022-12-10 03:03',
                updated_at: '2023-01-04 02:08',
                creator: null,
                actions: [
                  {
                    id: 16,
                    parent_id: 15,
                    permission_name: '列表',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Jobs@index',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 17,
                    parent_id: 15,
                    permission_name: '新增',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Jobs@store',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 2,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 18,
                    parent_id: 15,
                    permission_name: '读取',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Jobs@show',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 3,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 19,
                    parent_id: 15,
                    permission_name: '更新',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Jobs@update',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 4,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 20,
                    parent_id: 15,
                    permission_name: '删除',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Jobs@destroy',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 5,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 21,
                    parent_id: 15,
                    permission_name: '禁用/启用',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Jobs@enable',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 6,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  }
                ]
              },
              {
                id: 8,
                parent_id: 1,
                permission_name: '菜单管理',
                route: 'permissions',
                icon: 'finger-print',
                module: 'permissions',
                permission_mark: 'Permissions',
                component: '/Permissions/views/permissions/index.vue',
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 1,
                active_menu: '',
                creator_id: 0,
                created_at: '2022-12-10 03:02',
                updated_at: '2023-01-04 02:08',
                creator: null,
                actions: [
                  {
                    id: 9,
                    parent_id: 8,
                    permission_name: '列表',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Permissions@index',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 10,
                    parent_id: 8,
                    permission_name: '新增',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Permissions@store',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 2,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 11,
                    parent_id: 8,
                    permission_name: '读取',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Permissions@show',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 3,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 12,
                    parent_id: 8,
                    permission_name: '更新',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Permissions@update',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 4,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 13,
                    parent_id: 8,
                    permission_name: '删除',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Permissions@destroy',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 5,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  },
                  {
                    id: 14,
                    parent_id: 8,
                    permission_name: '禁用/启用',
                    route: '',
                    icon: '',
                    module: 'permissions',
                    permission_mark: 'Permissions@enable',
                    component: '',
                    redirect: '',
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 6,
                    active_menu: '',
                    creator_id: 1,
                    created_at: '2022-12-20 08:25',
                    updated_at: '2023-01-04 02:08'
                  }
                ]
              }
            ],
            actions: []
          }
        ]
      }
    }
  },
  {
    url: '/api/permissions/jobs',
    method: 'get',
    response: ({ query }) => {
      return {
        code: 10000,
        message: 'success',
        data: [
          {
            id: 1,
            job_name: '开发岗位',
            coding: null,
            status: 1,
            sort: 1,
            description: null,
            creator_id: 1,
            created_at: '2023-03-14 01:46',
            updated_at: '2023-03-14 01:46',
            creator: 'catchadmin'
          }
        ]
      }
    }
  }
] as MockMethod[]
