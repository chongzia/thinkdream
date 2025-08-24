<?php

namespace Modules\Common\Providers;

use Catch\Providers\CatchModuleServiceProvider;
use Modules\Common\Console\Area;

class CommonServiceProvider extends CatchModuleServiceProvider
{
    protected array $commands = [
        Area::class,
    ];

    /**
     * route path
     */
    public function moduleName(): string|array
    {
        // TODO: Implement path() method.
        return 'common';
    }
}
