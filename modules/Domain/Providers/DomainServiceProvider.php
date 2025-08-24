<?php

namespace Modules\Domain\Providers;

use Catch\Providers\CatchModuleServiceProvider;

class DomainServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     *
     * @return string
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'domain';
    }
}
