<?php

namespace Modules\Openapi\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Modules\Openapi\Enums\Code;
use Modules\Openapi\Exceptions\InvalidSignatureException;
use Modules\Openapi\Exceptions\LostException;
use Modules\Openapi\Facade\OpenapiAuth;
use Modules\Openapi\Models\OpenapiRequestLog;

/**
 * 校验签名
 */
class CheckSignatureMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $appKey = $request->header('app-key');
        $sign = $request->header('signature');
        // 为每次请求添加 request id
        Context::add('openapi_request_id', Str::uuid7());

        return match (true) {
            ! $appKey => throw new LostException(Code::APP_KEY_LOST->name(), Code::APP_KEY_LOST),
            ! $sign => throw new LostException(Code::SIGNATURE_LOST->name(), Code::SIGNATURE_LOST),
            ! OpenapiAuth::check($appKey, $sign, $request->all()) => throw new InvalidSignatureException,
            default => $next($request)
        };
    }
}
