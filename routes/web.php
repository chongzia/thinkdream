<?php
// web 路由
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('web/login', [AuthController::class, 'webLogin'])->withoutMiddleware([
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class
]);
