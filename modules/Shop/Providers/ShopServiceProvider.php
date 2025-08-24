<?php

namespace Modules\Shop\Providers;

use Catch\Providers\CatchModuleServiceProvider;

class ShopServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'shop';
    }
}
