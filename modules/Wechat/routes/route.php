<?php

use Illuminate\Support\Facades\Route;
use Modules\Wechat\Http\Controllers\OfficialAccountController;
use Modules\Wechat\Http\Controllers\OfficialMenuController;
use Modules\Wechat\Http\Controllers\WechatNewsController;
use Modules\Wechat\Http\Controllers\WechatUsersController;

// 无须鉴权
Route::withoutMiddleware(config('catch.route.middlewares'))
    ->prefix('wechat')
    ->group(function () {

        Route::prefix('official')->group(function () {
            Route::get('sign', [OfficialAccountController::class, 'sign']);
        });
    });

// 鉴权

Route::prefix('wechat')
    ->group(function () {
        Route::prefix('official')->group(function () {
            Route::apiResource('menu', OfficialMenuController::class)->only(['index', 'store']);
            Route::get('users', [WechatUsersController::class, 'index']);
            Route::put('user/block/{id}', [WechatUsersController::class, 'block']);
            Route::get('users/sync', [WechatUsersController::class, 'sync']);
            Route::apiResource('news', WechatNewsController::class);
            Route::put('news/enable/{id}', [WechatNewsController::class, 'enable']);
            //next
        });
    });
