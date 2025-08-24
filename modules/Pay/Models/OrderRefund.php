<?php

declare(strict_types=1);

namespace Modules\Pay\Models;

use Catch\Base\CatchModel as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property $id
 * @property $order_id
 * @property $order_no
 * @property $refund_no
 * @property $applicant_id
 * @property $operator_id
 * @property $refuse_reason
 * @property $amount
 * @property $reason
 * @property $refund_status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class OrderRefund extends Model
{
    /** 表名 */
    protected $table = 'pay_order_refunds';

    /** 允许填充字段 */
    protected $fillable = [
        'id',
        'order_id',
        'order_no',
        'refund_no',
        'amount',
        'reason',
        'refuse_reason',
        'refund_status',
        'applicant_id',
        'operator_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** 列表显示字段 */
    protected array $fields = [
        'id',
        'order_id',
        'order_no',
        'refund_no',
        'amount',
        'reason',
        'refund_status',
        'created_at',
        'updated_at',
    ];

    /** 表单填充字段 */
    protected array $form = ['order_id', 'order_no', 'refund_no', 'amount', 'reason', 'refund_status'];

    /** 搜索字段 */
    public array $searchable = [
        'order_no' => 'like',
        'refund_no' => 'like',
        'refund_status' => '=',
    ];

    /**
     * 创建退款单
     */
    public static function newOrderRefund(array $data): mixed
    {
        $refund = new self;

        return $refund->storeBy($data);
    }

    /**
     * 退款金额/分
     */
    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }
}
