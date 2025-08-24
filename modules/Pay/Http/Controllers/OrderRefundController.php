<?php

declare(strict_types=1);

namespace Modules\Pay\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Openapi\Exceptions\FailedException;
use Modules\Pay\Enums\RefundStatus;
use Modules\Pay\Models\Order;
use Modules\Pay\Models\OrderRefund;
use Modules\Pay\Support\PayFactory;

/**
 * @class OrderRefundController
 */
class OrderRefundController extends Controller
{
    public function __construct(
        protected readonly OrderRefund $model,
    ) {}

    /**
     * 列表
     */
    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     */
    public function agree($id, Request $request)
    {
        /* @var  OrderRefund $orderRefund */
        $orderRefund = OrderRefund::find($id);

        /* @var  Order $order */
        $order = Order::find($orderRefund->order_id);

        $isAgree = $request->get('is_agree');

        // 同意
        if ($isAgree) {
            return PayFactory::make($order->platform)->refund([
                'out_trade_no' => $order->out_trade_no,
                'amount' => $orderRefund->amount,
                'action' => $order->action,
            ]);
        }

        // 拒绝的话，直接结单
        if (! $refuseReason = $request->get('refuse_reason')) {
            throw new FailedException('拒绝原因不能为空');
        }

        return DB::transaction(function () use ($orderRefund, $order, $refuseReason) {
            $orderRefund->refund_status = RefundStatus::REFUSE;
            $orderRefund->refuse_reason = $refuseReason;
            $orderRefund->operator_id = $this->getLoginUserId();
            $orderRefund->save();

            $order->refund_status = RefundStatus::REFUSE;
            $order->save();
        });
    }
}
