<?php

namespace Modules\Pay\Listeners;

use Modules\Pay\Events\PayNotifyEvent;
use Modules\Pay\Support\Notify\AliPayNotify;
use Modules\Pay\Support\Notify\DouYinPayNotify;
use Modules\Pay\Support\Notify\UniPayNotify;
use Modules\Pay\Support\Notify\WechatPayNotify;
use Modules\Pay\Support\NotifyData\AliPayNotifyData;
use Modules\Pay\Support\NotifyData\DouYinPayNotifyData;
use Modules\Pay\Support\NotifyData\NotifyDataInterface;
use Modules\Pay\Support\NotifyData\UniPayNotifyData;
use Modules\Pay\Support\NotifyData\WechatPayNotifyData;

class PayNotifyListener
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
     * @param PayNotifyEvent $event
     * @throws \Throwable
     */
    public function handle(PayNotifyEvent $event): void
    {
        //
        $notifyData = $event->data;

        if ($notifyData instanceof AliPayNotifyData) {
            (new AliPayNotify($notifyData))->notify();
        }

        if ($notifyData instanceof WechatPayNotifyData) {
            (new WechatPayNotify($notifyData))->notify();
        }

        if ($notifyData instanceof UniPayNotifyData) {
            (new UniPayNotify($notifyData))->notify();
        }

        if ($notifyData instanceof DouYinPayNotifyData) {
            (new DouYinPayNotify($notifyData))->notify();
        }
    }
}
