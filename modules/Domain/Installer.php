<?php

namespace Modules\Domain;

use Catch\Support\Module\Installer as ModuleInstaller;
use Modules\Domain\Providers\DomainServiceProvider;

class Installer extends ModuleInstaller
{
    protected function info(): array
    {
        // TODO: Implement info() method.
        return [
            'title' => '域名管理',
            'name' => 'domain',
            'path' => 'Domain',
            'keywords' => '域名,域名管理',
            'description' => '用来管理域名的模块',
            'provider' => DomainServiceProvider::class,
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
