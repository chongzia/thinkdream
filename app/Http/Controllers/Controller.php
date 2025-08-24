<?php

namespace App\Http\Controllers;

use App\Support\ApiResponse;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Modules\Member\Models\Members;

/**
 * 基类控制器
 */
abstract class Controller
{
    /**
     * @return Members|null
     */
    protected function user(): ?Members
    {
        /** @var Members $user */
        $user = $this->appGuard()->user();
        return $user;
    }

    /**
     * 获取 app guard
     *
     * @return Guard|StatefulGuard
     */
    protected function appGuard(): Guard|StatefulGuard
    {
        return Auth::guard('app');
    }


    /**
     * 成功返回
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    protected function success(mixed $data = [], string $message = 'success'): JsonResponse
    {
        return ApiResponse::success($data, $message);
    }


    /**
     * 分页返回
     *
     * @param LengthAwarePaginator $paginator
     * @return JsonResponse
     */
    protected function paginate(LengthAwarePaginator $paginator): JsonResponse
    {
        return ApiResponse::paginate($paginator);
    }

    /**
     * 错误返回
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function error(string $message, int $code = 400): JsonResponse
    {
        return ApiResponse::error($message, $code);
    }
}
