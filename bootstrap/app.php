<?php

use App\Enums\Code;
use App\Exceptions\ApiAppException;
use App\Http\Middleware\AuthMiddleware;
use App\Support\ApiResponse;
use Catch\Support\HttpKernel;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Modules\Openapi\Exceptions\OpenapiException;
use Modules\Openapi\Facade\OpenapiResponse;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'auth' => AuthMiddleware::class, // 注册 app 应用中间件别名，支持注入 guard，例如 auth:app, auth:web 等等
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception, Request $request) {
            // openapi 异常
            if ($exception instanceof OpenapiException) {
                return OpenapiResponse::error($exception->getMessage(), $exception->getCode());
            }
            // api app 异常
            if ($exception instanceof ApiAppException) {
                return ApiResponse::error($exception->getMessage(), $exception->getCode());
            }

            // 其他系统异常自行处理, 请根据项目实际情况进行处理
            // 如果路由前缀使用 api/app 则返回 api app 异常
            if ($request->route()?->prefix('api/app')) {
                // 查询异常
                if ($exception instanceof QueryException) {
                    return ApiResponse::error($exception->getMessage(), Code::QUERY_FAILED);
                }

                return ApiResponse::error($exception->getMessage(), $exception->getCode());
            }

            // 如果路由前缀使用 api/v1 则返回 openapi 异常
            if ($request->route()?->prefix('api/v1')) {
                // 查询异常
                if ($exception instanceof QueryException) {
                    return ApiResponse::error($exception->getMessage(), Code::QUERY_FAILED);
                }

                return OpenapiResponse::error($exception->getMessage(), $exception->getCode());
            }
        });
    })->create();

// 接管自带的 Http Kernel
// 这个接管类不会带来任何影响，只是忽略了 terminating 异常，可以从日志查看[terminating log]
if (class_exists(HttpKernel::class)) {
    $app->singleton(Kernel::class, HttpKernel::class);
}

return $app;
