// mock/permissions.ts
var permissions_default = [
  {
    url: "/api/permissions/roles",
    method: "get",
    response: ({ query }) => {
      return {
        code: 1e4,
        message: "success",
        data: [
          {
            id: 1,
            role_name: "\u6D4B\u8BD5",
            identify: "test",
            parent_id: 0,
            description: null,
            data_range: 3,
            creator_id: 1,
            created_at: "2023-03-07 06:32",
            updated_at: "2023-03-07 06:32",
            creator: "catchadmin",
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
      };
    }
  },
  {
    url: "/api/permissions/roles",
    method: "get",
    response: ({ query }) => {
      return {
        code: 1e4,
        message: "success",
        data: [
          {
            id: 1,
            job_name: "\u5F00\u53D1\u5C97\u4F4D",
            coding: null,
            status: 1,
            sort: 1,
            description: null,
            creator_id: 1,
            created_at: "2023-03-14 01:46",
            updated_at: "2023-03-14 01:46",
            creator: "catchadmin"
          }
        ]
      };
    }
  },
  {
    url: "/api/permissions/departments",
    method: "get",
    response: ({ query }) => {
      return {
        code: 1e4,
        message: "success",
        data: [
          {
            id: 1,
            parent_id: 0,
            department_name: "\u603B\u90E8",
            principal: null,
            mobile: null,
            email: null,
            status: 1,
            sort: 1,
            creator_id: 1,
            created_at: "2023-03-14 01:47",
            updated_at: "2023-03-14 01:47",
            creator: "catchadmin",
            children: [
              {
                id: 3,
                parent_id: 1,
                department_name: "\u5357\u4EAC\u90E8\u95E8",
                principal: null,
                mobile: null,
                email: null,
                status: 1,
                sort: 1,
                creator_id: 1,
                created_at: "2023-03-14 01:47",
                updated_at: "2023-03-14 01:47",
                creator: "catchadmin"
              },
              {
                id: 2,
                parent_id: 1,
                department_name: "\u5317\u4EAC\u90E8\u95E8",
                principal: null,
                mobile: null,
                email: null,
                status: 1,
                sort: 1,
                creator_id: 1,
                created_at: "2023-03-14 01:47",
                updated_at: "2023-03-14 01:47",
                creator: "catchadmin"
              }
            ]
          }
        ]
      };
    }
  },
  {
    url: "/api/permissions/permissions",
    method: "get",
    response: ({ query }) => {
      return {
        code: 1e4,
        message: "success",
        data: [
          {
            id: 1,
            parent_id: 0,
            permission_name: "\u6743\u9650\u7BA1\u7406",
            route: "/permission",
            icon: "arrow-down-on-square-stack",
            module: "permissions",
            permission_mark: "",
            component: "/admin/layout/index.vue",
            redirect: null,
            keepalive: 1,
            type: 1,
            hidden: 1,
            sort: 1,
            active_menu: "",
            creator_id: 0,
            created_at: "2022-12-09 09:58",
            updated_at: "2023-01-04 02:08",
            creator: null,
            children: [
              {
                id: 2,
                parent_id: 1,
                permission_name: "\u89D2\u8272\u7BA1\u7406",
                route: "roles",
                icon: "arrow-left-circle",
                module: "permissions",
                permission_mark: "Roles",
                component: "/Permissions/views/roles/index.vue",
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 6,
                active_menu: "",
                creator_id: 0,
                created_at: "2022-12-09 09:59",
                updated_at: "2023-01-04 02:08",
                creator: null,
                actions: [
                  {
                    id: 3,
                    parent_id: 2,
                    permission_name: "\u5217\u8868",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Roles@index",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 09:00",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 4,
                    parent_id: 2,
                    permission_name: "\u65B0\u589E",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Roles@store",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 2,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 09:00",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 5,
                    parent_id: 2,
                    permission_name: "\u8BFB\u53D6",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Roles@show",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 3,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 09:00",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 6,
                    parent_id: 2,
                    permission_name: "\u66F4\u65B0",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Roles@update",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 4,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 09:00",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 7,
                    parent_id: 2,
                    permission_name: "\u5220\u9664",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Roles@destroy",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 5,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 09:00",
                    updated_at: "2023-01-04 02:08"
                  }
                ]
              },
              {
                id: 22,
                parent_id: 1,
                permission_name: "\u90E8\u95E8\u7BA1\u7406",
                route: "departments",
                icon: "table-cells",
                module: "permissions",
                permission_mark: "Departments",
                component: "/Permissions/views/departments/index.vue",
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 1,
                active_menu: "",
                creator_id: 0,
                created_at: "2022-12-10 03:03",
                updated_at: "2023-02-23 01:58",
                creator: null,
                actions: [
                  {
                    id: 23,
                    parent_id: 22,
                    permission_name: "\u5217\u8868",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Departments@index",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 02:04",
                    updated_at: "2023-02-23 01:58"
                  },
                  {
                    id: 24,
                    parent_id: 22,
                    permission_name: "\u65B0\u589E",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Departments@store",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 02:04",
                    updated_at: "2023-02-23 01:58"
                  },
                  {
                    id: 25,
                    parent_id: 22,
                    permission_name: "\u8BFB\u53D6",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Departments@show",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 02:04",
                    updated_at: "2023-02-23 01:58"
                  },
                  {
                    id: 26,
                    parent_id: 22,
                    permission_name: "\u66F4\u65B0",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Departments@update",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 06:21",
                    updated_at: "2023-02-23 01:58"
                  },
                  {
                    id: 27,
                    parent_id: 22,
                    permission_name: "\u5220\u9664",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Departments@destroy",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 06:22",
                    updated_at: "2023-02-23 01:58"
                  },
                  {
                    id: 28,
                    parent_id: 22,
                    permission_name: "\u7981\u7528/\u542F\u7528",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Departments@enable",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 6,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:21",
                    updated_at: "2023-02-23 01:58"
                  }
                ]
              },
              {
                id: 15,
                parent_id: 1,
                permission_name: "\u5C97\u4F4D\u7BA1\u7406",
                route: "jobs",
                icon: "globe-americas",
                module: "permissions",
                permission_mark: "Jobs",
                component: "/permission/jobs/index.vue",
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 1,
                active_menu: "",
                creator_id: 0,
                created_at: "2022-12-10 03:03",
                updated_at: "2023-01-04 02:08",
                creator: null,
                actions: [
                  {
                    id: 16,
                    parent_id: 15,
                    permission_name: "\u5217\u8868",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Jobs@index",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 17,
                    parent_id: 15,
                    permission_name: "\u65B0\u589E",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Jobs@store",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 2,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 18,
                    parent_id: 15,
                    permission_name: "\u8BFB\u53D6",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Jobs@show",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 3,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 19,
                    parent_id: 15,
                    permission_name: "\u66F4\u65B0",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Jobs@update",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 4,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 20,
                    parent_id: 15,
                    permission_name: "\u5220\u9664",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Jobs@destroy",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 5,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 21,
                    parent_id: 15,
                    permission_name: "\u7981\u7528/\u542F\u7528",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Jobs@enable",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 6,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  }
                ]
              },
              {
                id: 8,
                parent_id: 1,
                permission_name: "\u83DC\u5355\u7BA1\u7406",
                route: "permissions",
                icon: "finger-print",
                module: "permissions",
                permission_mark: "Permissions",
                component: "/Permissions/views/permissions/index.vue",
                redirect: null,
                keepalive: 1,
                type: 2,
                hidden: 1,
                sort: 1,
                active_menu: "",
                creator_id: 0,
                created_at: "2022-12-10 03:02",
                updated_at: "2023-01-04 02:08",
                creator: null,
                actions: [
                  {
                    id: 9,
                    parent_id: 8,
                    permission_name: "\u5217\u8868",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Permissions@index",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 1,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 10,
                    parent_id: 8,
                    permission_name: "\u65B0\u589E",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Permissions@store",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 2,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 11,
                    parent_id: 8,
                    permission_name: "\u8BFB\u53D6",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Permissions@show",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 3,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 12,
                    parent_id: 8,
                    permission_name: "\u66F4\u65B0",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Permissions@update",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 4,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 13,
                    parent_id: 8,
                    permission_name: "\u5220\u9664",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Permissions@destroy",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 5,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  },
                  {
                    id: 14,
                    parent_id: 8,
                    permission_name: "\u7981\u7528/\u542F\u7528",
                    route: "",
                    icon: "",
                    module: "permissions",
                    permission_mark: "Permissions@enable",
                    component: "",
                    redirect: "",
                    keepalive: 1,
                    type: 3,
                    hidden: 1,
                    sort: 6,
                    active_menu: "",
                    creator_id: 1,
                    created_at: "2022-12-20 08:25",
                    updated_at: "2023-01-04 02:08"
                  }
                ]
              }
            ],
            actions: []
          }
        ]
      };
    }
  },
  {
    url: "/api/permissions/jobs",
    method: "get",
    response: ({ query }) => {
      return {
        code: 1e4,
        message: "success",
        data: [
          {
            id: 1,
            job_name: "\u5F00\u53D1\u5C97\u4F4D",
            coding: null,
            status: 1,
            sort: 1,
            description: null,
            creator_id: 1,
            created_at: "2023-03-14 01:46",
            updated_at: "2023-03-14 01:46",
            creator: "catchadmin"
          }
        ]
      };
    }
  }
];
export {
  permissions_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsibW9jay9wZXJtaXNzaW9ucy50cyJdLAogICJzb3VyY2VzQ29udGVudCI6IFsiY29uc3QgX19pbmplY3RlZF9maWxlbmFtZV9fID0gXCIvVXNlcnMvamFja2phZ3Vhci9EYXRhL2NhdGNoYWRtaW4tcHJvL3dlYi9tb2NrL3Blcm1pc3Npb25zLnRzXCI7Y29uc3QgX19pbmplY3RlZF9kaXJuYW1lX18gPSBcIi9Vc2Vycy9qYWNramFndWFyL0RhdGEvY2F0Y2hhZG1pbi1wcm8vd2ViL21vY2tcIjtjb25zdCBfX2luamVjdGVkX2ltcG9ydF9tZXRhX3VybF9fID0gXCJmaWxlOi8vL1VzZXJzL2phY2tqYWd1YXIvRGF0YS9jYXRjaGFkbWluLXByby93ZWIvbW9jay9wZXJtaXNzaW9ucy50c1wiO2ltcG9ydCB7IE1vY2tNZXRob2QgfSBmcm9tICd2aXRlLXBsdWdpbi1tb2NrJ1xuXG5leHBvcnQgZGVmYXVsdCBbXG4gIHtcbiAgICB1cmw6ICcvYXBpL3Blcm1pc3Npb25zL3JvbGVzJyxcbiAgICBtZXRob2Q6ICdnZXQnLFxuICAgIHJlc3BvbnNlOiAoeyBxdWVyeSB9KSA9PiB7XG4gICAgICByZXR1cm4ge1xuICAgICAgICBjb2RlOiAxMDAwMCxcbiAgICAgICAgbWVzc2FnZTogJ3N1Y2Nlc3MnLFxuICAgICAgICBkYXRhOiBbXG4gICAgICAgICAge1xuICAgICAgICAgICAgaWQ6IDEsXG4gICAgICAgICAgICByb2xlX25hbWU6ICdcdTZENEJcdThCRDUnLFxuICAgICAgICAgICAgaWRlbnRpZnk6ICd0ZXN0JyxcbiAgICAgICAgICAgIHBhcmVudF9pZDogMCxcbiAgICAgICAgICAgIGRlc2NyaXB0aW9uOiBudWxsLFxuICAgICAgICAgICAgZGF0YV9yYW5nZTogMyxcbiAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMy0wMy0wNyAwNjozMicsXG4gICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMy0wNyAwNjozMicsXG4gICAgICAgICAgICBjcmVhdG9yOiAnY2F0Y2hhZG1pbicsXG4gICAgICAgICAgICBwZXJtaXNzaW9uczogW1xuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDFcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAxM1xuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDE0XG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogMTVcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAxNlxuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDE3XG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogMThcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAyXG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogMjFcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAyMlxuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDIzXG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogMjRcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAyNVxuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDI2XG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogMjdcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAyOFxuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDNcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiA0XG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogNVxuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDZcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiA3XG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogOFxuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDlcbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgXVxuICAgICAgICAgIH1cbiAgICAgICAgXVxuICAgICAgfVxuICAgIH1cbiAgfSxcbiAge1xuICAgIHVybDogJy9hcGkvcGVybWlzc2lvbnMvcm9sZXMnLFxuICAgIG1ldGhvZDogJ2dldCcsXG4gICAgcmVzcG9uc2U6ICh7IHF1ZXJ5IH0pID0+IHtcbiAgICAgIHJldHVybiB7XG4gICAgICAgIGNvZGU6IDEwMDAwLFxuICAgICAgICBtZXNzYWdlOiAnc3VjY2VzcycsXG4gICAgICAgIGRhdGE6IFtcbiAgICAgICAgICB7XG4gICAgICAgICAgICBpZDogMSxcbiAgICAgICAgICAgIGpvYl9uYW1lOiAnXHU1RjAwXHU1M0QxXHU1Qzk3XHU0RjREJyxcbiAgICAgICAgICAgIGNvZGluZzogbnVsbCxcbiAgICAgICAgICAgIHN0YXR1czogMSxcbiAgICAgICAgICAgIHNvcnQ6IDEsXG4gICAgICAgICAgICBkZXNjcmlwdGlvbjogbnVsbCxcbiAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMy0wMy0xNCAwMTo0NicsXG4gICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMy0xNCAwMTo0NicsXG4gICAgICAgICAgICBjcmVhdG9yOiAnY2F0Y2hhZG1pbidcbiAgICAgICAgICB9XG4gICAgICAgIF1cbiAgICAgIH1cbiAgICB9XG4gIH0sXG4gIHtcbiAgICB1cmw6ICcvYXBpL3Blcm1pc3Npb25zL2RlcGFydG1lbnRzJyxcbiAgICBtZXRob2Q6ICdnZXQnLFxuICAgIHJlc3BvbnNlOiAoeyBxdWVyeSB9KSA9PiB7XG4gICAgICByZXR1cm4ge1xuICAgICAgICBjb2RlOiAxMDAwMCxcbiAgICAgICAgbWVzc2FnZTogJ3N1Y2Nlc3MnLFxuICAgICAgICBkYXRhOiBbXG4gICAgICAgICAge1xuICAgICAgICAgICAgaWQ6IDEsXG4gICAgICAgICAgICBwYXJlbnRfaWQ6IDAsXG4gICAgICAgICAgICBkZXBhcnRtZW50X25hbWU6ICdcdTYwM0JcdTkwRTgnLFxuICAgICAgICAgICAgcHJpbmNpcGFsOiBudWxsLFxuICAgICAgICAgICAgbW9iaWxlOiBudWxsLFxuICAgICAgICAgICAgZW1haWw6IG51bGwsXG4gICAgICAgICAgICBzdGF0dXM6IDEsXG4gICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIzLTAzLTE0IDAxOjQ3JyxcbiAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAzLTE0IDAxOjQ3JyxcbiAgICAgICAgICAgIGNyZWF0b3I6ICdjYXRjaGFkbWluJyxcbiAgICAgICAgICAgIGNoaWxkcmVuOiBbXG4gICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBpZDogMyxcbiAgICAgICAgICAgICAgICBwYXJlbnRfaWQ6IDEsXG4gICAgICAgICAgICAgICAgZGVwYXJ0bWVudF9uYW1lOiAnXHU1MzU3XHU0RUFDXHU5MEU4XHU5NUU4JyxcbiAgICAgICAgICAgICAgICBwcmluY2lwYWw6IG51bGwsXG4gICAgICAgICAgICAgICAgbW9iaWxlOiBudWxsLFxuICAgICAgICAgICAgICAgIGVtYWlsOiBudWxsLFxuICAgICAgICAgICAgICAgIHN0YXR1czogMSxcbiAgICAgICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjMtMDMtMTQgMDE6NDcnLFxuICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAzLTE0IDAxOjQ3JyxcbiAgICAgICAgICAgICAgICBjcmVhdG9yOiAnY2F0Y2hhZG1pbidcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAyLFxuICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMSxcbiAgICAgICAgICAgICAgICBkZXBhcnRtZW50X25hbWU6ICdcdTUzMTdcdTRFQUNcdTkwRThcdTk1RTgnLFxuICAgICAgICAgICAgICAgIHByaW5jaXBhbDogbnVsbCxcbiAgICAgICAgICAgICAgICBtb2JpbGU6IG51bGwsXG4gICAgICAgICAgICAgICAgZW1haWw6IG51bGwsXG4gICAgICAgICAgICAgICAgc3RhdHVzOiAxLFxuICAgICAgICAgICAgICAgIHNvcnQ6IDEsXG4gICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMy0wMy0xNCAwMTo0NycsXG4gICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDMtMTQgMDE6NDcnLFxuICAgICAgICAgICAgICAgIGNyZWF0b3I6ICdjYXRjaGFkbWluJ1xuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICBdXG4gICAgICAgICAgfVxuICAgICAgICBdXG4gICAgICB9XG4gICAgfVxuICB9LFxuICB7XG4gICAgdXJsOiAnL2FwaS9wZXJtaXNzaW9ucy9wZXJtaXNzaW9ucycsXG4gICAgbWV0aG9kOiAnZ2V0JyxcbiAgICByZXNwb25zZTogKHsgcXVlcnkgfSkgPT4ge1xuICAgICAgcmV0dXJuIHtcbiAgICAgICAgY29kZTogMTAwMDAsXG4gICAgICAgIG1lc3NhZ2U6ICdzdWNjZXNzJyxcbiAgICAgICAgZGF0YTogW1xuICAgICAgICAgIHtcbiAgICAgICAgICAgIGlkOiAxLFxuICAgICAgICAgICAgcGFyZW50X2lkOiAwLFxuICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU2NzQzXHU5NjUwXHU3QkExXHU3NDA2JyxcbiAgICAgICAgICAgIHJvdXRlOiAnL3Blcm1pc3Npb24nLFxuICAgICAgICAgICAgaWNvbjogJ2Fycm93LWRvd24tb24tc3F1YXJlLXN0YWNrJyxcbiAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJycsXG4gICAgICAgICAgICBjb21wb25lbnQ6ICcvYWRtaW4vbGF5b3V0L2luZGV4LnZ1ZScsXG4gICAgICAgICAgICByZWRpcmVjdDogbnVsbCxcbiAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgIHR5cGU6IDEsXG4gICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgY3JlYXRvcl9pZDogMCxcbiAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTA5IDA5OjU4JyxcbiAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4JyxcbiAgICAgICAgICAgIGNyZWF0b3I6IG51bGwsXG4gICAgICAgICAgICBjaGlsZHJlbjogW1xuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDIsXG4gICAgICAgICAgICAgICAgcGFyZW50X2lkOiAxLFxuICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1ODlEMlx1ODI3Mlx1N0JBMVx1NzQwNicsXG4gICAgICAgICAgICAgICAgcm91dGU6ICdyb2xlcycsXG4gICAgICAgICAgICAgICAgaWNvbjogJ2Fycm93LWxlZnQtY2lyY2xlJyxcbiAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnUm9sZXMnLFxuICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJy9QZXJtaXNzaW9ucy92aWV3cy9yb2xlcy9pbmRleC52dWUnLFxuICAgICAgICAgICAgICAgIHJlZGlyZWN0OiBudWxsLFxuICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICB0eXBlOiAyLFxuICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICBzb3J0OiA2LFxuICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAwLFxuICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTA5IDA5OjU5JyxcbiAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMS0wNCAwMjowOCcsXG4gICAgICAgICAgICAgICAgY3JlYXRvcjogbnVsbCxcbiAgICAgICAgICAgICAgICBhY3Rpb25zOiBbXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAzLFxuICAgICAgICAgICAgICAgICAgICBwYXJlbnRfaWQ6IDIsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1NTIxN1x1ODg2OCcsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnUm9sZXNAaW5kZXgnLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDA5OjAwJyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDEtMDQgMDI6MDgnXG4gICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogNCxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiAyLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdTY1QjBcdTU4OUUnLFxuICAgICAgICAgICAgICAgICAgICByb3V0ZTogJycsXG4gICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxuICAgICAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ1JvbGVzQHN0b3JlJyxcbiAgICAgICAgICAgICAgICAgICAgY29tcG9uZW50OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgcmVkaXJlY3Q6ICcnLFxuICAgICAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IDMsXG4gICAgICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICAgICAgc29ydDogMixcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0yMCAwOTowMCcsXG4gICAgICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4J1xuICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWQ6IDUsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMixcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU4QkZCXHU1M0Q2JyxcbiAgICAgICAgICAgICAgICAgICAgcm91dGU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBpY29uOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdSb2xlc0BzaG93JyxcbiAgICAgICAgICAgICAgICAgICAgY29tcG9uZW50OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgcmVkaXJlY3Q6ICcnLFxuICAgICAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IDMsXG4gICAgICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICAgICAgc29ydDogMyxcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0yMCAwOTowMCcsXG4gICAgICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4J1xuICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWQ6IDYsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMixcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU2NkY0XHU2NUIwJyxcbiAgICAgICAgICAgICAgICAgICAgcm91dGU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBpY29uOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdSb2xlc0B1cGRhdGUnLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiA0LFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDA5OjAwJyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDEtMDQgMDI6MDgnXG4gICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogNyxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiAyLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdTUyMjBcdTk2NjQnLFxuICAgICAgICAgICAgICAgICAgICByb3V0ZTogJycsXG4gICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxuICAgICAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ1JvbGVzQGRlc3Ryb3knLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiA1LFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDA5OjAwJyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDEtMDQgMDI6MDgnXG4gICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgXVxuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgaWQ6IDIyLFxuICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMSxcbiAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdTkwRThcdTk1RThcdTdCQTFcdTc0MDYnLFxuICAgICAgICAgICAgICAgIHJvdXRlOiAnZGVwYXJ0bWVudHMnLFxuICAgICAgICAgICAgICAgIGljb246ICd0YWJsZS1jZWxscycsXG4gICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ0RlcGFydG1lbnRzJyxcbiAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcvUGVybWlzc2lvbnMvdmlld3MvZGVwYXJ0bWVudHMvaW5kZXgudnVlJyxcbiAgICAgICAgICAgICAgICByZWRpcmVjdDogbnVsbCxcbiAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgdHlwZTogMixcbiAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgc29ydDogMSxcbiAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMCxcbiAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0xMCAwMzowMycsXG4gICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDItMjMgMDE6NTgnLFxuICAgICAgICAgICAgICAgIGNyZWF0b3I6IG51bGwsXG4gICAgICAgICAgICAgICAgYWN0aW9uczogW1xuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogMjMsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMjIsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1NTIxN1x1ODg2OCcsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnRGVwYXJ0bWVudHNAaW5kZXgnLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDAyOjA0JyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDItMjMgMDE6NTgnXG4gICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogMjQsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMjIsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1NjVCMFx1NTg5RScsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnRGVwYXJ0bWVudHNAc3RvcmUnLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDAyOjA0JyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDItMjMgMDE6NTgnXG4gICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogMjUsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMjIsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1OEJGQlx1NTNENicsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnRGVwYXJ0bWVudHNAc2hvdycsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDI6MDQnLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMi0yMyAwMTo1OCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAyNixcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiAyMixcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU2NkY0XHU2NUIwJyxcbiAgICAgICAgICAgICAgICAgICAgcm91dGU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBpY29uOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdEZXBhcnRtZW50c0B1cGRhdGUnLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDA2OjIxJyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDItMjMgMDE6NTgnXG4gICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogMjcsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMjIsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1NTIyMFx1OTY2NCcsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnRGVwYXJ0bWVudHNAZGVzdHJveScsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDY6MjInLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMi0yMyAwMTo1OCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAyOCxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiAyMixcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU3OTgxXHU3NTI4L1x1NTQyRlx1NzUyOCcsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnRGVwYXJ0bWVudHNAZW5hYmxlJyxcbiAgICAgICAgICAgICAgICAgICAgY29tcG9uZW50OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgcmVkaXJlY3Q6ICcnLFxuICAgICAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IDMsXG4gICAgICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICAgICAgc29ydDogNixcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0yMCAwODoyMScsXG4gICAgICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAyLTIzIDAxOjU4J1xuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiAxNSxcbiAgICAgICAgICAgICAgICBwYXJlbnRfaWQ6IDEsXG4gICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU1Qzk3XHU0RjREXHU3QkExXHU3NDA2JyxcbiAgICAgICAgICAgICAgICByb3V0ZTogJ2pvYnMnLFxuICAgICAgICAgICAgICAgIGljb246ICdnbG9iZS1hbWVyaWNhcycsXG4gICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ0pvYnMnLFxuICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJy9wZXJtaXNzaW9uL2pvYnMvaW5kZXgudnVlJyxcbiAgICAgICAgICAgICAgICByZWRpcmVjdDogbnVsbCxcbiAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgdHlwZTogMixcbiAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgc29ydDogMSxcbiAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMCxcbiAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0xMCAwMzowMycsXG4gICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDEtMDQgMDI6MDgnLFxuICAgICAgICAgICAgICAgIGNyZWF0b3I6IG51bGwsXG4gICAgICAgICAgICAgICAgYWN0aW9uczogW1xuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogMTYsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMTUsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1NTIxN1x1ODg2OCcsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnSm9ic0BpbmRleCcsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDg6MjUnLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMS0wNCAwMjowOCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAxNyxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiAxNSxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU2NUIwXHU1ODlFJyxcbiAgICAgICAgICAgICAgICAgICAgcm91dGU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBpY29uOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdKb2JzQHN0b3JlJyxcbiAgICAgICAgICAgICAgICAgICAgY29tcG9uZW50OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgcmVkaXJlY3Q6ICcnLFxuICAgICAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IDMsXG4gICAgICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICAgICAgc29ydDogMixcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0yMCAwODoyNScsXG4gICAgICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4J1xuICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWQ6IDE4LFxuICAgICAgICAgICAgICAgICAgICBwYXJlbnRfaWQ6IDE1LFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdThCRkJcdTUzRDYnLFxuICAgICAgICAgICAgICAgICAgICByb3V0ZTogJycsXG4gICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxuICAgICAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ0pvYnNAc2hvdycsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDMsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDg6MjUnLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMS0wNCAwMjowOCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAxOSxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiAxNSxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU2NkY0XHU2NUIwJyxcbiAgICAgICAgICAgICAgICAgICAgcm91dGU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBpY29uOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdKb2JzQHVwZGF0ZScsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDQsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDg6MjUnLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMS0wNCAwMjowOCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAyMCxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiAxNSxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU1MjIwXHU5NjY0JyxcbiAgICAgICAgICAgICAgICAgICAgcm91dGU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBpY29uOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdKb2JzQGRlc3Ryb3knLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiA1LFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDA4OjI1JyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDEtMDQgMDI6MDgnXG4gICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogMjEsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMTUsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1Nzk4MVx1NzUyOC9cdTU0MkZcdTc1MjgnLFxuICAgICAgICAgICAgICAgICAgICByb3V0ZTogJycsXG4gICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxuICAgICAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ0pvYnNAZW5hYmxlJyxcbiAgICAgICAgICAgICAgICAgICAgY29tcG9uZW50OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgcmVkaXJlY3Q6ICcnLFxuICAgICAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IDMsXG4gICAgICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICAgICAgc29ydDogNixcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0yMCAwODoyNScsXG4gICAgICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4J1xuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIGlkOiA4LFxuICAgICAgICAgICAgICAgIHBhcmVudF9pZDogMSxcbiAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdTgzRENcdTUzNTVcdTdCQTFcdTc0MDYnLFxuICAgICAgICAgICAgICAgIHJvdXRlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgIGljb246ICdmaW5nZXItcHJpbnQnLFxuICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdQZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgY29tcG9uZW50OiAnL1Blcm1pc3Npb25zL3ZpZXdzL3Blcm1pc3Npb25zL2luZGV4LnZ1ZScsXG4gICAgICAgICAgICAgICAgcmVkaXJlY3Q6IG51bGwsXG4gICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgIHR5cGU6IDIsXG4gICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgIHNvcnQ6IDEsXG4gICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDAsXG4gICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMTAgMDM6MDInLFxuICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4JyxcbiAgICAgICAgICAgICAgICBjcmVhdG9yOiBudWxsLFxuICAgICAgICAgICAgICAgIGFjdGlvbnM6IFtcbiAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWQ6IDksXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogOCxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU1MjE3XHU4ODY4JyxcbiAgICAgICAgICAgICAgICAgICAgcm91dGU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBpY29uOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgbW9kdWxlOiAncGVybWlzc2lvbnMnLFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX21hcms6ICdQZXJtaXNzaW9uc0BpbmRleCcsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDg6MjUnLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMS0wNCAwMjowOCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAxMCxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiA4LFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdTY1QjBcdTU4OUUnLFxuICAgICAgICAgICAgICAgICAgICByb3V0ZTogJycsXG4gICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxuICAgICAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ1Blcm1pc3Npb25zQHN0b3JlJyxcbiAgICAgICAgICAgICAgICAgICAgY29tcG9uZW50OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgcmVkaXJlY3Q6ICcnLFxuICAgICAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IDMsXG4gICAgICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICAgICAgc29ydDogMixcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0yMCAwODoyNScsXG4gICAgICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4J1xuICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgaWQ6IDExLFxuICAgICAgICAgICAgICAgICAgICBwYXJlbnRfaWQ6IDgsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbmFtZTogJ1x1OEJGQlx1NTNENicsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnUGVybWlzc2lvbnNAc2hvdycsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDMsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDg6MjUnLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMS0wNCAwMjowOCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAxMixcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiA4LFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdTY2RjRcdTY1QjAnLFxuICAgICAgICAgICAgICAgICAgICByb3V0ZTogJycsXG4gICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxuICAgICAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ1Blcm1pc3Npb25zQHVwZGF0ZScsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBvbmVudDogJycsXG4gICAgICAgICAgICAgICAgICAgIHJlZGlyZWN0OiAnJyxcbiAgICAgICAgICAgICAgICAgICAga2VlcGFsaXZlOiAxLFxuICAgICAgICAgICAgICAgICAgICB0eXBlOiAzLFxuICAgICAgICAgICAgICAgICAgICBoaWRkZW46IDEsXG4gICAgICAgICAgICAgICAgICAgIHNvcnQ6IDQsXG4gICAgICAgICAgICAgICAgICAgIGFjdGl2ZV9tZW51OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRvcl9pZDogMSxcbiAgICAgICAgICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjItMTItMjAgMDg6MjUnLFxuICAgICAgICAgICAgICAgICAgICB1cGRhdGVkX2F0OiAnMjAyMy0wMS0wNCAwMjowOCdcbiAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIGlkOiAxMyxcbiAgICAgICAgICAgICAgICAgICAgcGFyZW50X2lkOiA4LFxuICAgICAgICAgICAgICAgICAgICBwZXJtaXNzaW9uX25hbWU6ICdcdTUyMjBcdTk2NjQnLFxuICAgICAgICAgICAgICAgICAgICByb3V0ZTogJycsXG4gICAgICAgICAgICAgICAgICAgIGljb246ICcnLFxuICAgICAgICAgICAgICAgICAgICBtb2R1bGU6ICdwZXJtaXNzaW9ucycsXG4gICAgICAgICAgICAgICAgICAgIHBlcm1pc3Npb25fbWFyazogJ1Blcm1pc3Npb25zQGRlc3Ryb3knLFxuICAgICAgICAgICAgICAgICAgICBjb21wb25lbnQ6ICcnLFxuICAgICAgICAgICAgICAgICAgICByZWRpcmVjdDogJycsXG4gICAgICAgICAgICAgICAgICAgIGtlZXBhbGl2ZTogMSxcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogMyxcbiAgICAgICAgICAgICAgICAgICAgaGlkZGVuOiAxLFxuICAgICAgICAgICAgICAgICAgICBzb3J0OiA1LFxuICAgICAgICAgICAgICAgICAgICBhY3RpdmVfbWVudTogJycsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0b3JfaWQ6IDEsXG4gICAgICAgICAgICAgICAgICAgIGNyZWF0ZWRfYXQ6ICcyMDIyLTEyLTIwIDA4OjI1JyxcbiAgICAgICAgICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDEtMDQgMDI6MDgnXG4gICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBpZDogMTQsXG4gICAgICAgICAgICAgICAgICAgIHBhcmVudF9pZDogOCxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9uYW1lOiAnXHU3OTgxXHU3NTI4L1x1NTQyRlx1NzUyOCcsXG4gICAgICAgICAgICAgICAgICAgIHJvdXRlOiAnJyxcbiAgICAgICAgICAgICAgICAgICAgaWNvbjogJycsXG4gICAgICAgICAgICAgICAgICAgIG1vZHVsZTogJ3Blcm1pc3Npb25zJyxcbiAgICAgICAgICAgICAgICAgICAgcGVybWlzc2lvbl9tYXJrOiAnUGVybWlzc2lvbnNAZW5hYmxlJyxcbiAgICAgICAgICAgICAgICAgICAgY29tcG9uZW50OiAnJyxcbiAgICAgICAgICAgICAgICAgICAgcmVkaXJlY3Q6ICcnLFxuICAgICAgICAgICAgICAgICAgICBrZWVwYWxpdmU6IDEsXG4gICAgICAgICAgICAgICAgICAgIHR5cGU6IDMsXG4gICAgICAgICAgICAgICAgICAgIGhpZGRlbjogMSxcbiAgICAgICAgICAgICAgICAgICAgc29ydDogNixcbiAgICAgICAgICAgICAgICAgICAgYWN0aXZlX21lbnU6ICcnLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgICAgICAgICBjcmVhdGVkX2F0OiAnMjAyMi0xMi0yMCAwODoyNScsXG4gICAgICAgICAgICAgICAgICAgIHVwZGF0ZWRfYXQ6ICcyMDIzLTAxLTA0IDAyOjA4J1xuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIGFjdGlvbnM6IFtdXG4gICAgICAgICAgfVxuICAgICAgICBdXG4gICAgICB9XG4gICAgfVxuICB9LFxuICB7XG4gICAgdXJsOiAnL2FwaS9wZXJtaXNzaW9ucy9qb2JzJyxcbiAgICBtZXRob2Q6ICdnZXQnLFxuICAgIHJlc3BvbnNlOiAoeyBxdWVyeSB9KSA9PiB7XG4gICAgICByZXR1cm4ge1xuICAgICAgICBjb2RlOiAxMDAwMCxcbiAgICAgICAgbWVzc2FnZTogJ3N1Y2Nlc3MnLFxuICAgICAgICBkYXRhOiBbXG4gICAgICAgICAge1xuICAgICAgICAgICAgaWQ6IDEsXG4gICAgICAgICAgICBqb2JfbmFtZTogJ1x1NUYwMFx1NTNEMVx1NUM5N1x1NEY0RCcsXG4gICAgICAgICAgICBjb2Rpbmc6IG51bGwsXG4gICAgICAgICAgICBzdGF0dXM6IDEsXG4gICAgICAgICAgICBzb3J0OiAxLFxuICAgICAgICAgICAgZGVzY3JpcHRpb246IG51bGwsXG4gICAgICAgICAgICBjcmVhdG9yX2lkOiAxLFxuICAgICAgICAgICAgY3JlYXRlZF9hdDogJzIwMjMtMDMtMTQgMDE6NDYnLFxuICAgICAgICAgICAgdXBkYXRlZF9hdDogJzIwMjMtMDMtMTQgMDE6NDYnLFxuICAgICAgICAgICAgY3JlYXRvcjogJ2NhdGNoYWRtaW4nXG4gICAgICAgICAgfVxuICAgICAgICBdXG4gICAgICB9XG4gICAgfVxuICB9XG5dIGFzIE1vY2tNZXRob2RbXVxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUVBLElBQU8sc0JBQVE7QUFBQSxFQUNiO0FBQUEsSUFDRSxLQUFLO0FBQUEsSUFDTCxRQUFRO0FBQUEsSUFDUixVQUFVLENBQUMsRUFBRSxNQUFNLE1BQU07QUFDdkIsYUFBTztBQUFBLFFBQ0wsTUFBTTtBQUFBLFFBQ04sU0FBUztBQUFBLFFBQ1QsTUFBTTtBQUFBLFVBQ0o7QUFBQSxZQUNFLElBQUk7QUFBQSxZQUNKLFdBQVc7QUFBQSxZQUNYLFVBQVU7QUFBQSxZQUNWLFdBQVc7QUFBQSxZQUNYLGFBQWE7QUFBQSxZQUNiLFlBQVk7QUFBQSxZQUNaLFlBQVk7QUFBQSxZQUNaLFlBQVk7QUFBQSxZQUNaLFlBQVk7QUFBQSxZQUNaLFNBQVM7QUFBQSxZQUNULGFBQWE7QUFBQSxjQUNYO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFBLGNBQ047QUFBQSxjQUNBO0FBQUEsZ0JBQ0UsSUFBSTtBQUFB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
