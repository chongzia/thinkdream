<?php

namespace Modules\Shop\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductHasSpecs extends Pivot
{
    protected $table = 'shop_product_has_specs';

    public $timestamps = false;
}
