<?php

use Illuminate\Database\Seeder;
use Modules\Common\Support\ImportPermissions;

return new class extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run(): void
    {
        $menus = $this->menus();

        ImportPermissions::import($menus);
    }

    public function menus(): array
    {
        return array (
            0 =>
                array (
                    'id' => 154,
                    'parent_id' => 0,
                    'permission_name' => '微信管理',
                    'route' => '/wechat',
                    'icon' => 'newspaper',
                    'module' => 'wechat',
                    'permission_mark' => '',
                    'component' => '/layout/index.vue',
                    'redirect' => NULL,
                    'keepalive' => 1,
                    'type' => 1,
                    'hidden' => 1,
                    'sort' => 1,
                    'active_menu' => '',
                    'creator_id' => 1,
                    'created_at' => '2023-06-05 11:12',
                    'updated_at' => '2023-06-05 11:12',
                    'children' =>
                        array (
                            0 =>
                                array (
                                    'id' => 155,
                                    'parent_id' => 154,
                                    'permission_name' => '菜单管理',
                                    'route' => 'menu',
                                    'icon' => '',
                                    'module' => 'wechat',
                                    'permission_mark' => 'officialMenu',
                                    'component' => '/wechat/menu/index.vue',
                                    'redirect' => NULL,
                                    'keepalive' => 1,
                                    'type' => 2,
                                    'hidden' => 1,
                                    'sort' => 1,
                                    'active_menu' => '',
                                    'creator_id' => 1,
                                    'created_at' => '2023-06-05 11:13',
                                    'updated_at' => '2023-06-05 11:13',
                                ),
                            1 =>
                                array (
                                    'id' => 159,
                                    'parent_id' => 154,
                                    'permission_name' => '图文管理',
                                    'route' => 'wechatNews',
                                    'icon' => '',
                                    'module' => 'wechat',
                                    'permission_mark' => 'wechatNews',
                                    'component' => '/wechat/wechatNews/index.vue',
                                    'redirect' => NULL,
                                    'keepalive' => 1,
                                    'type' => 2,
                                    'hidden' => 1,
                                    'sort' => 1,
                                    'active_menu' => '',
                                    'creator_id' => 1,
                                    'created_at' => '2023-06-07 20:22',
                                    'updated_at' => '2023-06-07 20:22',
                                    'children' =>
                                        array (
                                            0 =>
                                                array (
                                                    'id' => 166,
                                                    'parent_id' => 159,
                                                    'permission_name' => '删除',
                                                    'route' => '',
                                                    'icon' => '',
                                                    'module' => 'wechat',
                                                    'permission_mark' => 'wechatNews@destroy',
                                                    'component' => '',
                                                    'redirect' => '',
                                                    'keepalive' => 1,
                                                    'type' => 3,
                                                    'hidden' => 1,
                                                    'sort' => 5,
                                                    'active_menu' => '',
                                                    'creator_id' => 1,
                                                    'created_at' => '2023-06-14 10:08',
                                                    'updated_at' => '2023-06-14 10:08',
                                                ),
                                            1 =>
                                                array (
                                                    'id' => 162,
                                                    'parent_id' => 159,
                                                    'permission_name' => '列表',
                                                    'route' => '',
                                                    'icon' => '',
                                                    'module' => 'wechat',
                                                    'permission_mark' => 'wechatNews@index',
                                                    'component' => '',
                                                    'redirect' => '',
                                                    'keepalive' => 1,
                                                    'type' => 3,
                                                    'hidden' => 1,
                                                    'sort' => 1,
                                                    'active_menu' => '',
                                                    'creator_id' => 1,
                                                    'created_at' => '2023-06-14 10:08',
                                                    'updated_at' => '2023-06-14 10:08',
                                                ),
                                            2 =>
                                                array (
                                                    'id' => 164,
                                                    'parent_id' => 159,
                                                    'permission_name' => '读取',
                                                    'route' => '',
                                                    'icon' => '',
                                                    'module' => 'wechat',
                                                    'permission_mark' => 'wechatNews@show',
                                                    'component' => '',
                                                    'redirect' => '',
                                                    'keepalive' => 1,
                                                    'type' => 3,
                                                    'hidden' => 1,
                                                    'sort' => 3,
                                                    'active_menu' => '',
                                                    'creator_id' => 1,
                                                    'created_at' => '2023-06-14 10:08',
                                                    'updated_at' => '2023-06-14 10:08',
                                                ),
                                            3 =>
                                                array (
                                                    'id' => 163,
                                                    'parent_id' => 159,
                                                    'permission_name' => '新增',
                                                    'route' => '',
                                                    'icon' => '',
                                                    'module' => 'wechat',
                                                    'permission_mark' => 'wechatNews@store',
                                                    'component' => '',
                                                    'redirect' => '',
                                                    'keepalive' => 1,
                                                    'type' => 3,
                                                    'hidden' => 1,
                                                    'sort' => 2,
                                                    'active_menu' => '',
                                                    'creator_id' => 1,
                                                    'created_at' => '2023-06-14 10:08',
                                                    'updated_at' => '2023-06-14 10:08',
                                                ),
                                            4 =>
                                                array (
                                                    'id' => 165,
                                                    'parent_id' => 159,
                                                    'permission_name' => '更新',
                                                    'route' => '',
                                                    'icon' => '',
                                                    'module' => 'wechat',
                                                    'permission_mark' => 'wechatNews@update',
                                                    'component' => '',
                                                    'redirect' => '',
                                                    'keepalive' => 1,
                                                    'type' => 3,
                                                    'hidden' => 1,
                                                    'sort' => 4,
                                                    'active_menu' => '',
                                                    'creator_id' => 1,
                                                    'created_at' => '2023-06-14 10:08',
                                                    'updated_at' => '2023-06-14 10:08',
                                                ),
                                        ),
                                ),
                            2 =>
                                array (
                                    'id' => 156,
                                    'parent_id' => 154,
                                    'permission_name' => '用户管理',
                                    'route' => 'wechatUsers',
                                    'icon' => '',
                                    'module' => 'wechat',
                                    'permission_mark' => 'wechatUsers',
                                    'component' => '/wechat/wechatUsers/index.vue',
                                    'redirect' => NULL,
                                    'keepalive' => 1,
                                    'type' => 2,
                                    'hidden' => 1,
                                    'sort' => 1,
                                    'active_menu' => '',
                                    'creator_id' => 1,
                                    'created_at' => '2023-06-06 15:09',
                                    'updated_at' => '2023-06-06 15:09',
                                    'children' =>
                                        array (
                                            0 =>
                                                array (
                                                    'id' => 158,
                                                    'parent_id' => 156,
                                                    'permission_name' => '删除',
                                                    'route' => '',
                                                    'icon' => '',
                                                    'module' => 'wechat',
                                                    'permission_mark' => 'wechatUsers@destroy',
                                                    'component' => '',
                                                    'redirect' => '',
                                                    'keepalive' => 1,
                                                    'type' => 3,
                                                    'hidden' => 1,
                                                    'sort' => 2,
                                                    'active_menu' => '',
                                                    'creator_id' => 1,
                                                    'created_at' => '2023-06-06 15:09',
                                                    'updated_at' => '2023-06-06 15:09',
                                                ),
                                            1 =>
                                                array (
                                                    'id' => 157,
                                                    'parent_id' => 156,
                                                    'permission_name' => '列表',
                                                    'route' => '',
                                                    'icon' => '',
                                                    'module' => 'wechat',
                                                    'permission_mark' => 'wechatUsers@index',
                                                    'component' => '',
                                                    'redirect' => '',
                                                    'keepalive' => 1,
                                                    'type' => 3,
                                                    'hidden' => 1,
                                                    'sort' => 1,
                                                    'active_menu' => '',
                                                    'creator_id' => 1,
                                                    'created_at' => '2023-06-06 15:09',
                                                    'updated_at' => '2023-06-06 15:09',
                                                ),
                                        ),
                                ),
                        ),
                ),
        );
    }
};
