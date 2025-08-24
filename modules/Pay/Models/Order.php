<?php

declare(strict_types=1);

namespace Modules\Pay\Models;

use Catch\Base\CatchModel as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Pay\Enums\PayAction;
use Modules\Pay\Enums\PayPlatform;
use Modules\Pay\Enums\PayStatus;
use Modules\Pay\Enums\RefundStatus;

/**
 * @property $id
 * @property $subject_id
 * @property $user_id
 * @property $order_no
 * @property $out_trade_no
 * @property $amount
 * @property $platform
 * @property $action
 * @property $pay_status
 * @property $refund_status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Order extends Model
{
    /** 表名 */
    protected $table = 'pay_orders';

    /** 允许填充字段 */
    protected $fillable = [
        'id',
        'subject_id',
        'user_id',
        'order_no',
        'out_trade_no',
        'amount',
        'platform',
        'action',
        'pay_status',
        'refund_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** 列表显示字段 */
    protected array $fields = [
        'id',
        'subject_id',
        'user_id',
        'order_no',
        'out_trade_no',
        'amount',
        'platform',
        'action',
        'pay_status',
        'refund_status',
        'created_at',
        'updated_at',
    ];

    /** 表单填充字段 */
    protected array $form = [
        'subject_id',
        'user_id',
        'order_no',
        'out_trade_no',
        'amount',
        'platform',
        'action',
        'pay_status',
        'refund_status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'platform' => PayPlatform::class,
        'action' => PayAction::class,
        'pay_status' => PayStatus::class,
        'refund_status' => RefundStatus::class,
    ];

    /** 搜索字段 */
    public array $searchable = [
        'order_no' => 'like',
        'out_trade_no' => 'like',
        'status' => '=',
        'refund_status' => '=',
    ];

    /**
     * 是否待支付
     */
    public function isPayPending(): bool
    {
        return $this->pay_status == PayStatus::PENDING;
    }

    /**
     * 是否支付成功
     */
    public function isPaySuccess(): bool
    {
        return $this->pay_status == PayStatus::SUCCESS;
    }

    /**
     * 是否支付失败
     */
    public function isPayFail(): bool
    {
        return $this->pay_status == PayStatus::FAILED;
    }

    /**
     * 是否支付超时
     */
    public function isPayTimeout(): bool
    {
        return $this->pay_status == PayStatus::TIMEOUT;
    }

    public function isRefundSuccess(): bool
    {
        return $this->refund_status == RefundStatus::SUCCESS;
    }

    public function isRefundFail(): bool
    {
        return $this->refund_status == RefundStatus::FAILED;
    }

    public function isRefundPending(): bool
    {
        return $this->refund_status == RefundStatus::PENDING;
    }

    public function isRefund(): bool
    {
        return $this->refund_status == RefundStatus::NONE;
    }

    /**
     * 支付金额
     */
    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    /**
     * 创建订单
     *
     * @param array $order
     * @return bool|Order
     */
    public static function createNew(array $data): static|bool
    {
        $order = new self;

        $data['created_at'] = $data['updated_at'] = time();
        if ($order->fill($data)->save()) {
            return $order;
        }

        return false;
    }
}
