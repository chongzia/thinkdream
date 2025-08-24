<?php

declare(strict_types=1);

namespace Modules\Pay\Enums;

use Catch\Enums\Enum;

enum PayPlatform: int implements Enum
{
    case ALIPAY = 1;
    case WECHAT = 2;
    case UNIPAY = 3;
    case DOUYIN = 4;

    /**
     * Get the platform value
     */
    public function value(): int|string
    {
        return $this->value;
    }

    /**
     * Get the platform name
     */
    public function name(): string
    {
        return match ($this) {
            self::ALIPAY => '支付宝',
            self::WECHAT => '微信',
            self::UNIPAY => '银联',
            self::DOUYIN => '抖音',
        };
    }

    /**
     * Check if the enum value equals the given value
     */
    public function assert($value): bool
    {
        return $this->value() == $value;
    }
}
