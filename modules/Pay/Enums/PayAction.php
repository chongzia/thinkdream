<?php
namespace Modules\Pay\Enums;

use Catch\Enums\Enum;

/**
 * 退款时的 action
 */
enum PayAction: string implements Enum
{
    case APP = 'app';
    case H5 = 'h5';
    case MINI = 'mini';
    case POS = 'pos';
    case SCAN = 'scan';
    case WEB = 'web'; // 支付宝
    case MP = 'mp'; // 微信公众号支付

    public function value(): int|string
    {
        // TODO: Implement value() method.
        return $this->value;
    }

    public function name(): string
    {
        // TODO: Implement name() method.
        return match ($this) {
            self::APP => 'APP',
            self::H5 => 'H5',
            self::MINI => '小程序',
            self::WEB => 'WEB网页',
            self::POS => 'POS机',
            self::SCAN => '扫码',
            self::MP => '微信公众号',
        };
    }
}
