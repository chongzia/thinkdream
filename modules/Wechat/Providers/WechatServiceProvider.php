<?php

namespace Modules\Wechat\Providers;

use Catch\Providers\CatchModuleServiceProvider;

class WechatServiceProvider extends CatchModuleServiceProvider
{
    /**
     * route path
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'wechat';
    }
}
