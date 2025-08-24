<?php
namespace App\Services\Auth;

use App\Exceptions\FailedException;
use Illuminate\Support\Facades\Auth;

/**
 *  Class WechatLogin
 *
 *  密码登录
 *
 * @namespace App\Services\Auth
 */
class PasswordLogin extends Login
{
    public function auth(array $params)
    {
        $field = preg_match('/^1\d{10}$/', $params['account']) ? 'mobile' : 'username';

        try {
            // Auth 认证
            $token = Auth::guard('app')->attempt([
                $field => $params['account'],
                'password' => $params['password'],
            ]);

            if ($token) {
                return [Auth::guard('app')->user(), $token];
            }

            return false;
        } catch (\Throwable $e) {
            throw new FailedException($e->getMessage());
        }
    }
}
