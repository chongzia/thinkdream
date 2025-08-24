<?php

namespace Modules\System\Listeners;

use Catch\Events\ReportException;
use Modules\System\Models\Webhooks;
use Modules\System\Support\Webhook;

class ReportExceptionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ReportException $event
     * @return void
     */
    public function handle(ReportException $event): void
    {
        //
        $webhook = new Webhook(Webhooks::exceptions());

        $webhook->setValues([$event->exception->getMessage(), $event->exception->getFile()])->send();
    }
}
