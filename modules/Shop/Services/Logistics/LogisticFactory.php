<?php
namespace Modules\Shop\Services\Logistics;

use Catch\Exceptions\FailedException;

class LogisticFactory
{
    const GLOBAL_LOGISTIC = 'global';

    public static function make($logistic = 'global'): string
    {
        return match ($logistic) {
            self::GLOBAL_LOGISTIC => GlobalLogistic::class,
            default => throw new FailedException('不支持该物流服务'),
        };
    }
}
