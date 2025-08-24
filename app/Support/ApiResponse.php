<?php

namespace App\Support;

use App\Enums\Enum;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enums\Code;

class ApiResponse
{
    /**
     * 成功响应
     */
    public static function success(mixed $data = [], string $message = 'success', Code $code = Code::SUCCESS): JsonResponse
    {
        return response()->json([
            'code' => $code->value,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * 错误响应
     */
    public static function error(string $message = 'api error', int|Code $code = Code::FAILED): JsonResponse
    {
        return response()->json([
            'code' => $code instanceof Enum ? $code->value : $code,
            'message' => $message,
        ]);
    }

    /**
     * 分页响应
     */
    public static function paginate(LengthAwarePaginator $paginator, string $message = 'success', Code $code = Code::SUCCESS): JsonResponse
    {
        return response()->json([
            'code' => $code->value,
            'message' => $message,
            'data' => $paginator->items(),
            'total' => $paginator->total(),
            'limit' => $paginator->perPage(),
            'page' => $paginator->currentPage(),
        ]);
    }
}
