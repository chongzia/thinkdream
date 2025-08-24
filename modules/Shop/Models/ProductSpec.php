<?php

namespace Modules\Shop\Models;

use Catch\Base\CatchModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shop\Models\Pivots\ProductHasSpecs;

class ProductSpec extends CatchModel
{
    protected $table = 'shop_product_spec';

    protected $fillable = [
        'id', 'name', 'spec_tmp_id', 'creator_id', 'created_at', 'updated_at',
    ];

    /**
     * 规格值
     */
    public function values(): HasMany
    {
        return $this->hasMany(ProductSpecValues::class, 'spec_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function productValues(): BelongsToMany
    {
        return $this->belongsToMany(ProductSpecValues::class, ProductHasSpecs::class, 'spec_id', 'spec_value_id');
    }
}
