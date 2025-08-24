<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pay_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id')->comment('商品ID');
            $table->integer('user_id')->comment('用户ID');
            $table->string('order_no')->comment('本地订单号');
            $table->string('out_trade_no')->comment('外部订单号')->nullable();
            $table->integer('amount')->comment('金额/分');
            $table->tinyInteger('platform')->comment('支付平台:1=支付宝,2=微信,3=银联,4=抖音');
            $table->string('action', 10)->comment('支付操作: web, app, miniapp... 每个平台不同');
            $table->tinyInteger('pay_status')->comment('支付状态:1=待支付,2=支付成功,3=支付失败,4=超时未支付');
            $table->tinyInteger('refund_status')->comment('退款状态:0=未退款,1=待退款,2=退款成功,3=退款失败,4=拒绝退款')->default(0);
            $table->createdAt();
            $table->updatedAt();
            $table->deletedAt();

            $table->comment('订单表');
        });

        Schema::create('pay_order_refunds', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->comment('订单ID');
            $table->string('order_no')->comment('订单号');
            $table->string('refund_no')->comment('退款单号');
            $table->integer('amount')->comment('退款金额/分');
            $table->string('reason')->comment('退款原因')->default('退款');
            $table->string('refuse_reason')->nullable()->comment('拒绝原因');
            $table->integer('applicant_id')->comment('申请人ID，后台申请')->nullable();
            $table->integer('operator_id')->comment('操作人ID，后台操作')->nullable();
            $table->tinyInteger('refund_status')->comment('退款状态:1=待退款,2=退款成功,3=退款失败,4=拒绝退款')->default(1);
            $table->createdAt();
            $table->updatedAt();
            $table->deletedAt();

            $table->comment('退款表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_orders');

        Schema::dropIfExists('pay_order_refunds');
    }
};
