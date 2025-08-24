<?php

namespace Modules\Permissions\Providers;

use Catch\Providers\CatchModuleServiceProvider;
use Modules\Permissions\Middlewares\PermissionGate;

class PermissionsServiceProvider extends CatchModuleServiceProvider
{
    /**
     * middlewares
     *
     * @return string[]
     */
    protected function middlewares(): array
    {
        return [PermissionGate::class];
    }

    /**
     * route path
     */
    public function moduleName(): string|array
    {
        // TODO: Implement path() method.
        return 'permissions';
    }
}
