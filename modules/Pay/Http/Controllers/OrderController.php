<?php

declare(strict_types=1);

namespace Modules\Pay\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Openapi\Exceptions\FailedException;
use Modules\Pay\Enums\RefundStatus;
use Modules\Pay\Models\Order;
use Modules\Pay\Models\OrderRefund;
use Modules\Pay\Support\PayFactory;

/**
 * @class OrderController
 */
class OrderController extends Controller
{
    public function __construct(
        protected readonly Order $model,
    ) {}

    /**
     * 列表
     */
    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * 发起退款
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function refund($id, Request $request): mixed
    {
        $refundAmount = $request->get('refund_amount');
        $reason = $request->get('reason');

        /* @var Order $order */
        $order = $this->model->find($id);

        if ($refundAmount > $order?->amount) {
            throw new FailedException('退款金额不能大于支付金额');
        }

        return DB::transaction(function () use ($order, $refundAmount, $reason) {
            $order->refund_status = RefundStatus::PENDING;
            $order->save();

            return OrderRefund::newOrderRefund([
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'applicant_id' => $this->getLoginUserId(),
                'refund_no' => PayFactory::make($order->platform)->createRefundOrderNo(),
                'amount' => $refundAmount,
                'reason' => $reason,
                'refund_status' => RefundStatus::PENDING,
            ]);
        });
    }
}
