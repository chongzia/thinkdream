<?php

namespace Modules\Pay;

use Catch\Support\Module\Installer as ModuleInstaller;
use Modules\Pay\Providers\PayServiceProvider;

class Installer extends ModuleInstaller
{
    protected function info(): array
    {
        // TODO: Implement info() method.
        return [
            'title' => '支付模块',
            'name' => 'pay',
            'path' => 'Pay',
            'keywords' => '支付宝，微信支付，抖音支付',
            'description' => '支付模块对接',
            'provider' => PayServiceProvider::class,
        ];
    }

    protected function requirePackages(): void
    {
        // TODO: Implement requirePackages() method.
    }

    protected function removePackages(): void
    {
        // TODO: Implement removePackages() method.
    }
}
