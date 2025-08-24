<?php

namespace Modules\Member;

use Catch\Support\Module\Installer as ModuleInstaller;
use Modules\Member\Providers\MemberServiceProvider;

class Installer extends ModuleInstaller
{
    protected function info(): array
    {
        // TODO: Implement info() method.
        return [
            'title' => '会员管理',
            'name' => 'member',
            'path' => 'member',
            'keywords' => '会员管理',
            'description' => '会员管理模块',
            'provider' => MemberServiceProvider::class,
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
