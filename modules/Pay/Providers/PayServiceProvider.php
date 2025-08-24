<?php

namespace Modules\Pay\Providers;

use Catch\Providers\CatchModuleServiceProvider;
use Modules\Pay\Events\PayEvent;
use Modules\Pay\Events\PayNotifyEvent;
use Modules\Pay\Listeners\PayListener;
use Modules\Pay\Listeners\PayNotifyListener;

class PayServiceProvider extends CatchModuleServiceProvider
{
    protected array $events = [
        PayNotifyEvent::class => PayNotifyListener::class,
        PayEvent::class => PayListener::class,
    ];

    /**
     * route path
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'Pay';
    }
}
