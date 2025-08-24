<?php

namespace Modules\Shop\Services\Product;

use Modules\Shop\Services\Product\Pipes\Basic;
use Modules\Shop\Services\Product\Pipes\Config;
use Modules\Shop\Services\Product\Pipes\Info;
use Modules\Shop\Services\Product\Pipes\Specifications;
use Modules\Shop\Services\Product\Pipes\RemoveShip;

/**
 * 卡密产品
 */
class SerialNumberProduct extends Product
{
    protected array $pipes = [
        Basic::class, // 基本信息
        Specifications::class, // 规格
        Info::class, // 关联信息
        RemoveShip::class, // 删除运费
        Config::class, // 高级设置
    ];
}
