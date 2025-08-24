<?php

declare(strict_types=1);

namespace Modules\Common\Enums;

use Catch\Enums\Enum;

/**
 * @title 工单模板状态
 * @description 工单模板状态
 * @class TicketTemplatesStatus
 */
enum TicketTemplatesStatus: int implements Enum
{
    case ENABLE = 1;
    case DISABLE = 2;

    public function name(): string
    {
        return match ($this) {
            self::ENABLE => '启用',
            self::DISABLE => '禁用',
        };
    }

    public function value(): string|int
    {
        return match ($this) {
            self::ENABLE => 1,
            self::DISABLE => 2,
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
