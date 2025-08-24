<?php

namespace Modules\Shop\Models;

use Catch\Base\CatchModel;

class ProductSpecValues extends CatchModel
{
    protected $table = 'shop_product_spec_value';

    protected $fillable = [
        'id', 'value', 'creator_id', 'spec_id', 'created_at', 'updated_at',
    ];
}
