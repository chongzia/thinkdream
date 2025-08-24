<?php

namespace Modules\Member\Providers;

use Catch\Providers\CatchModuleServiceProvider;

class MemberServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'Member';
    }
}
