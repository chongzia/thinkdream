<?php

use Illuminate\Support\Facades\Route;
use Modules\Pay\Http\Controllers\ConfigController;
use Modules\Pay\Http\Controllers\OrderController;
use Modules\Pay\Http\Controllers\OrderRefundController;

Route::prefix('pay')->group(function () {
    // 获取配置
    Route::get('config/{driver}', [ConfigController::class, 'show']);
    // 保存配置
    Route::post('config', [ConfigController::class, 'store']);

    Route::adminResource('order', OrderController::class);
    // 申请退款单
    Route::post('order/{id}/refund', [OrderController::class, 'refund']);

    Route::adminResource('order/refund', OrderRefundController::class);
    // 同意退款
    Route::post('order/refund/{id}/agree', [OrderRefundController::class, 'agree']);
    // next
});
