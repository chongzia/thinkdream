<?php
namespace Modules\Pay\Enums;

use Catch\Enums\Enum;

/**
 * 退款时的 action
 */
enum RefundAction: string implements Enum
{
    case APP = 'app';
    case H5 = 'h5';
    case MINI = 'mini';
    case WEB = 'web'; // 支付宝
    case POS = 'pos'; // 支付宝
    case SCAN = 'scan'; // 支付宝
    case JSAPI = 'jsapi'; // 微信公众号支付
    case COMBINE = 'combine'; // 微信组合支付
    case NATIVE = 'native'; // 微信原生支付
    case QR_CODE = 'qr_code'; // 银联二维码

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
            self::WEB => 'WEB',
            self::POS => 'POS',
            self::SCAN => 'SCAN',
            self::JSAPI => 'JSAPI',
            self::COMBINE => 'COMBINE',
            self::NATIVE => 'NATIVE',
            self::QR_CODE => 'QR_CODE',
        };
    }
}
