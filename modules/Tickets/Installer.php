<?php

namespace Modules\Tickets;

use Catch\Support\Module\Installer as ModuleInstaller;
use Modules\Tickets\Providers\TicketsServiceProvider;

class Installer extends ModuleInstaller
{
    protected function info(): array
    {
        // TODO: Implement info() method.
        return [
            'title' => '工单管理',
            'name' => 'tickets',
            'path' => 'Tickets',
            'keywords' => '_tickets',
            'description' => '工单管理',
            'provider' => TicketsServiceProvider::class,
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
