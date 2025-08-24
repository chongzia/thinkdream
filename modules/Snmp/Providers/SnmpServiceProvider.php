<?php

namespace Modules\Snmp\Providers;

use Catch\CatchAdmin;
use Catch\Providers\CatchModuleServiceProvider;

class SnmpServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     *
     * @return string
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'snmp';
    }
}
