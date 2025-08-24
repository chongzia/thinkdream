<?php

namespace App\Services\Auth;

class UserService
{
    /**
     * 适配器类型
     */
    protected string $type;

    public function auth(array $params)
    {
        /* @var Login $loginAdapter */
        $loginAdapter = app($this->getLoginAdapter($this->type));

        if ($res = $loginAdapter->auth($params)) {
            [$user, $token] = $res;

            $user->rememberToken($token);

            return $user->makeHidden([
                'password', 'from', 'creator_id',
            ]);
        }

        return false;
    }

    /**
     * 获取登录适配器
     */
    protected function getLoginAdapter(string $type): string
    {
        return [
            'password' => PasswordLogin::class,
            'wechat' => WechatLogin::class,
            'wechat_mobile' => WechatByMobileLogin::class,
        ][$type];
    }

    /**
     * @return $this
     */
    public function setAdapterType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
