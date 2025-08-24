<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;
use Modules\Shop\Models\Products;
use Modules\Shop\Models\SeckillProducts;

class SeckillProductRequest extends Request
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'array', function (string $attribute, mixed $value, \Closure $fail) {
                // 更新的验证
                if ($id = $this->route('product')) {
                    if (SeckillProducts::where('id', '<>', $id)->where('product_id', $this->product_id[0])->exists()) {
                        $fail('秒杀商品【'.Products::where('id', $this->product_id[0])->value('title').'】已存在, 重新选择商品');
                    }
                } else {
                    foreach ($this->product_id as $productId) {
                        if (SeckillProducts::where('id', $productId)->exists()) {
                            $fail('秒杀商品【'.Products::where('id', $productId)->value('title').'】已存在, 重新选择商品');
                            break;
                        }
                    }
                }
            }],
            'seckill_price' => 'required|min:0',
            'stock' => 'required|min:0',
            'limit_per_user' => 'required|numeric|min:0',
            'sort' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => '选择秒杀商品',
            'seckill_price.required' => '秒杀价格必须填写',
            'seckill_price.min' => '秒杀价格不能小于0',
            'stock.required' => '秒杀库存必须填写',
            'stock.min' => '秒杀库存不能小于0',
            'limit_per_user.required' => '每人限购必须填写',
            'limit_per_user.numeric' => '每人限购必须是数字',
            'limit_per_user.min' => '每人限购不能小于0',
            'sort.required' => '排序必须填写',
            'sort.numeric' => '排序必须是数字',
            'sort.min' => '排序不能小于1',
        ];
    }
}
