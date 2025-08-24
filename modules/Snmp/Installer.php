<?php

namespace Modules\Snmp;

use Catch\Support\Module\Installer as ModuleInstaller;
use Modules\Snmp\Providers\SnmpServiceProvider;

class Installer extends ModuleInstaller
{
    protected function info(): array
    {
        // TODO: Implement info() method.
        return [
            'title' => 'snmp',
            'name' => 'snmp',
            'path' => 'Snmp',
            'keywords' => 'snmp',
            'description' => 'snmp',
            'provider' => SnmpServiceProvider::class,
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
