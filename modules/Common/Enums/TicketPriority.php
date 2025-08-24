<?php

declare(strict_types=1);

namespace Modules\Common\Enums;

use Catch\Enums\Enum;

/**
 * @title 工单优先级
 * @description 工单优先级
 * @class TicketPriority
 */
enum TicketPriority: int implements Enum
{
    case MINOR = 1;
    case MODERATE = 2;
    case CRITICAL = 3;
    case SPECIAL = 4;

    public function name(): string
    {
        return match($this) {
            self::MINOR => '低',
            self::MODERATE => '中',
            self::CRITICAL => '高',
            self::SPECIAL => '特',
        };
    }

    public function value(): string|int
    {
        return $this->value;
    }

    /**
     * 判断值是否匹配
     * @param mixed $value
     * @return bool
     */
    public function assert(mixed $value): bool
    {
        return $this->value === $value;
    }
}