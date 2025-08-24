<?php

namespace App\Services\Auth;

use App\Exceptions\UnauthorizedAccessException;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 *  Class WechatLogin
 *
 *  微信登录
 *
 * @namespace App\Services\Auth
 */
class WechatLogin extends Login
{
    public function auth(array $params)
    {

        try {
            $response = $this->getMiniAppApplication()->getUtils()->codeToSession($params['code']);

            $user = $this->getAuthModel()->firstOrCreate([
                'miniapp_openid' => $response['openid'],
            ], [
                'username' => $params['username'],
                'from' => 'miniprogram',
                'miniapp_openid' => $response['openid'],
                'avatar' => $this->storeAvatar(),
                'mobile' => '',
                'created_at' => time(),
                'last_login_at' => time(),
                'updated_at' => time(),
            ]);

            if (! $user) {
                return false;
            }

            return [$user, JWTAuth::fromUser($user)];
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new UnauthorizedAccessException;
        }
    }
}
