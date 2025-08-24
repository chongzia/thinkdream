<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// app 应用路由
Route::prefix('app')->group(function () {
    // 不需要身份认证的路由
    Route::post('login', [AuthController::class, 'login']);

    // 需要身份认证的路由
    Route::middleware('auth:app')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// 开放接口路由
/**
Route::prefix('v1')->middleware([
    \Modules\Openapi\Middlewares\CheckSignatureMiddleware::class,
    \Modules\Openapi\Middlewares\RateLimiterMiddleware::class,
])->group(function () {
    Route::get('user', function () {
        return \Modules\Openapi\Facade\OpenapiResponse::success([]);
    });
});*/
