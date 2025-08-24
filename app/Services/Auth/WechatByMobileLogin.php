<?php

namespace App\Services\Auth;

use App\Exceptions\UnauthorizedAccessException;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 *  Class WechatLogin
 *
 *  微信手机号登录
 *
 * @namespace App\Services\Auth
 */
class WechatByMobileLogin extends Login
{
    public function auth(array $params)
    {
        // TODO: Implement auth() method.
        try {
            Log::info('微信手机号登录: '.json_encode($params));
            $openid = $this->getMiniAppOpenId($params['code']);
            Log::info('微信手机号登录: '.$openid);

            $user = $this->getAuthModel()->where('miniapp_openid', $openid)->first();
            if ($user) {
                $user->username = $params['username'];
                $user->mobile = $this->getMiniAppUserMobile($params['phoneCode']);
                $user->avatar = $this->storeAvatar();
                $user->last_login_at = time();
                $user->updated_at = time();
                $user->save();
            } else {
                $user = $this->getAuthModel()->firstOrCreate([
                    'mobile' => $this->getMiniAppUserMobile($params['phoneCode']),
                ], [
                    'username' => $params['username'],
                    'from' => 'miniprogram',
                    'avatar' => $this->storeAvatar(),
                    'miniapp_openid' => $openid,
                    'created_at' => time(),
                    'last_login_at' => time(),
                    'updated_at' => time(),
                ]);
            }

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
