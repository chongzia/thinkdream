<?php

namespace Modules\Openapi\Providers;

use Catch\Providers\CatchModuleServiceProvider;
use Modules\Openapi\Support\OpenapiAuth;

class OpenapiServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'openapi';
    }

    public function boot(): void
    {
        $this->app->singleton(OpenapiAuth::class, fn () => new OpenapiAuth);
    }
}
