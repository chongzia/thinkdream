<?php

namespace Modules\User\Services;

use Catch\Exceptions\FailedException;
use Illuminate\Support\Facades\Event;
use Modules\User\Events\Login;
use Modules\User\Services\Login\Factory;

class Auth
{
    public function attempt(array $params): array
    {
        try {
            $auth = Factory::make($params);

            $user = $auth->auth($params);

            $token = $user->createToken('token', expiresAt: config('sanctum.expiration') ? now()->addMinutes(config('sanctum.expiration')) : null)->plainTextToken;
            Event::dispatch(new Login($user, $token));

            return compact('token');
        } catch (\Exception|\Throwable $e) {
            // 登录失败日志
            Event::dispatch(new Login(null));
            throw new FailedException($e->getMessage());
        }
    }
}
