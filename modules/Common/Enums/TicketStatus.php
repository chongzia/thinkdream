<?php

declare(strict_types=1);

namespace Modules\Common\Enums;

use Catch\Enums\Enum;

/**
 * @title 工单状态
 * @description 工单状态
 * @class TicketStatus
 */
enum TicketStatus: int implements Enum
{
    case PENDING = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;
    case PROCESSING = 4;
    case COMPLETED = 6;

    public function name(): string
    {
        return match ($this) {
            self::PENDING => '待处理',
            self::ACCEPTED => '已受理',
            self::REJECTED => '已拒绝',
            self::PROCESSING => '处理中',
            self::COMPLETED => '已完成',
        };
    }

    public function value(): string|int
    {
        return match ($this) {
            self::PENDING => 1,
            self::ACCEPTED => 2,
            self::REJECTED => 3,
            self::PROCESSING => 4,
            self::COMPLETED => 6,
        };
    }

    /**
     * 判断值是否匹配
     * @param  mixed  $value
     * @return bool
     */
    public function assert(mixed $value): bool
    {
        return $this->value === $value;
    }
}
