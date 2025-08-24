<?php

namespace Modules\Shop\Services\Product;

use Catch\Exceptions\FailedException;
use Modules\Shop\Enums\ProductTypes;

class ProductFactory
{
    public static function make($productType): string
    {
        $products = [
            ProductTypes::PHYSICAL->value() => PhysicalProduct::class,
            ProductTypes::SERIAL_NUMBER->value() => SerialNumberProduct::class,
            ProductTypes::VIRTUAL->value() => VirtualProduct::class,
        ];

        if (isset($products[$productType])) {
            return $products[$productType];
        }

        throw new FailedException('该商品类型目前不支持');
    }
}
