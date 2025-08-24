<?php

namespace Modules\Pay\Support\Notify;

use Illuminate\Support\Facades\Cache;
use Modules\Pay\Support\NotifyData\NotifyDataInterface;

/**
 * Class Notify
 *
 * 回调类
 */
abstract class Notify
{
    public function __construct(
        protected NotifyDataInterface $data
    ) {}

    /**
     * 回调
     *
     * @return mixed|void
     *
     * @throws \Throwable
     */
    public function notify()
    {
        $lock = Cache::lock('pay-notify-'.$this->data->getOutTradeNo(), 10);
        try {
            if ($this->data->isRefund()) {
                return $this->refundNotify();
            }

            if ($this->data->isRefund()) {
                return $this->payNotify();
            }
        } finally {
            $lock->release();
        }
    }

    /**
     * 退款回调
     */
    abstract public function refundNotify(): mixed;

    /**
     * 支付回调
     */
    abstract public function payNotify(): mixed;
}
