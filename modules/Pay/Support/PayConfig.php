<?php

namespace Modules\Pay\Support;

use Laravel\Octane\Exceptions\DdException;
use Modules\Openapi\Exceptions\FailedException;

/**
 * 支付配置
 */
class PayConfig
{
    /**
     * @return array[]
     * @throws DdException
     */
    public static function get(?string $key = null): array
    {
        $payConfig = [];

        if ($key) {
            if (! config('pay.'.$key)) {
                throw new FailedException('支付配置不存在');
            }

            $payConfig[$key] = [
                'default' => config('pay.'.$key),
            ];
        } else {
            if ($alipayConfig = config('pay.alipay')) {
                $payConfig['alipay'] = [
                    'default' => $alipayConfig,
                ];
            }

            if ($wechatConfig = config('pay.wechat')) {
                $payConfig['wechat'] = [
                    'default' => $wechatConfig,
                ];
            }

            if ($unipayConfig = config('pay.unipay')) {
                $payConfig['unipay'] = [
                    'default' => $unipayConfig,
                ];
            }

            if ($douyinConfig = config('pay.douyin')) {
                $payConfig['douyin'] = [
                    'default' => $douyinConfig,
                ];
            }
        }

        foreach ($payConfig as $platform => &$config) {
            if (! $config) {
                continue;
            }

            foreach ($config['default'] as $k => $value) {
                // 如果以 certs 开头,则替换为绝对路径
                if (str_starts_with($value, 'certs')) {
                    if (! file_exists($certPath = storage_path($value))) {
                        throw new FailedException("{$platform} 平台 {$key} 证书文件不存在, 路径 {$value}");
                    }

                    $config['default'][$k] = $certPath;
                }
            }
        }

        // 设置 http 配置
        $payConfig['http'] = [
            'timeout' => 5.0,
            'verify' => false,
        ];

        return $payConfig;
    }
}
