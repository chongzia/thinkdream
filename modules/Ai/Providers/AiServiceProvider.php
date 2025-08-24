<?php

namespace Modules\Ai\Providers;

use Catch\Providers\CatchModuleServiceProvider;

class AiServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     *
     * @return string
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'ai';
    }
}
