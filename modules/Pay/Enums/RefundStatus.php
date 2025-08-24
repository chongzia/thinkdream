<?php

declare(strict_types=1);

namespace Modules\Pay\Enums;

use Catch\Enums\Enum;

enum RefundStatus: int implements Enum
{
    case NONE = 0;
    case PENDING = 1;
    case SUCCESS = 2;
    case FAILED = 3;
    case REFUSE = 4;

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
            self::NONE => '未退款',
            self::PENDING => '待退款',
            self::SUCCESS => '退款成功',
            self::FAILED => '退款失败',
            self::REFUSE => '拒绝退款',
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
