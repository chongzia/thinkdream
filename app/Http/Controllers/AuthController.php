<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedAccessException;
use App\Services\Auth\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * app 应用认证
 */
class AuthController extends Controller
{
    /**
     * 登录
     */
    public function login(Request $request, UserService $service): JsonResponse
    {
        $user = $service->setAdapterType($request->get('type'))->auth($request->all());

        if (! $user) {
            throw new UnauthorizedAccessException;
        }

        return $this->success($user);
    }

    /**
     * 登出
     */
    public function logout(): JsonResponse
    {
        $this->appGuard()->logout(true);

        return $this->success();
    }
}
