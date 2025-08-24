<?php

namespace Modules\Tickets\Providers;

use Catch\CatchAdmin;
use Catch\Providers\CatchModuleServiceProvider;

class TicketsServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     *
     * @return string
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'tickets';
    }
}
