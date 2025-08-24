<?php

declare(strict_types=1);

namespace Modules\Pay\Enums;

use Catch\Enums\Enum;

enum PayStatus: int implements Enum
{
    case PENDING = 1;
    case SUCCESS = 2;
    case FAILED = 3;
    case TIMEOUT = 4;

    /**
     * Get the status value
     */
    public function value(): int|string
    {
        return $this->value;
    }

    /**
     * Get the status name
     */
    public function name(): string
    {
        return match ($this) {
            self::PENDING => '待支付',
            self::SUCCESS => '支付成功',
            self::FAILED => '支付失败',
            self::TIMEOUT => '超时未支付',
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
