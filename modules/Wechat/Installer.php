<?php

namespace Modules\Wechat;

use Catch\Support\Module\Installer as ModuleInstaller;
use Modules\Wechat\Providers\WechatServiceProvider;

class Installer extends ModuleInstaller
{
    protected function info(): array
    {
        // TODO: Implement info() method.
        return [
            'title' => '微信管理',
            'name' => 'wechat',
            'path' => 'wechat',
            'keywords' => '微信管理, wechat',
            'description' => '微信管理模块',
            'provider' => WechatServiceProvider::class,
        ];
    }

    protected function requirePackages(): void
    {
        // TODO: Implement requirePackages() method.
    }

    protected function removePackages(): void
    {
        // TODO: Implement removePackages() method.
    }
}
