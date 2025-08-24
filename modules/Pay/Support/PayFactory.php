<?php

namespace Modules\Pay\Support;

use Modules\Pay\Enums\PayPlatform as Pay;
use Modules\Pay\Exceptions\PayPlatformNotSupportException;

/**
 * @class PayFactory
 *
 * @desc 支付工厂类
 */
class PayFactory
{
    /**
     * @param Pay $platform
     * @return PayInterface
     */
    public static function make(Pay $platform): PayInterface
    {
        return match ($platform) {
            Pay::WECHAT => new WechatPay,
            Pay::ALIPAY => new AliPay,
            Pay::UNIPAY => new UniPay,
            Pay::DOUYIN => new DouYinPay,
            default => throw new PayPlatformNotSupportException("支付平台{$platform->value()}不支持")
        };
    }
}
