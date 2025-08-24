<?php

namespace App\Services\Auth;

use EasyWeChat\Kernel\Exceptions\BadResponseException;
use EasyWeChat\Kernel\Exceptions\HttpException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\MiniApp\Application;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class Login
 */
abstract class Login
{
    /**
     * @return mixed
     */
    abstract public function auth(array $params);

    /**
     * @throws InvalidArgumentException
     */
    protected function getMiniAppApplication(): Application
    {
        $config = [
            'app_id' => config('wechat.mini_program.app_id'),
            'secret' => config('wechat.mini_program.app_secret'),
        ];

        if (config('wechat.mini_program.token')) {
            $config['token'] = config('wechat.mini_program.token');
        }

        if (config('wechat.mini_program.encoding_aeskey')) {
            $config['aes_key'] = config('wechat.mini_program.encoding_aeskey');
        }
Log::info(json_encode($config, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
        return new Application($config);
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    protected function getAuthModel(): mixed
    {
        $provider = config('auth.guards.app.provider');

        return app(config('auth.providers.'.$provider.'.model'));
    }

    /**
     * 获取微信小程序 openid
     *
     * @throws InvalidArgumentException
     * @throws HttpException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function getMiniAppOpenId(string $code): string
    {
        $response = $this->getMiniAppApplication()->getUtils()->codeToSession($code);

        return $response['openid'];
    }

    /**
     * 获取微信小程序手机号
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws BadResponseException
     */
    protected function getMiniAppUserMobile(string $phoneCode): string
    {
        // 直接请求微信接口获取手机号
        $response = $this->getMiniAppApplication()->getClient()->postJson('/wxa/business/getuserphonenumber', [
            'code' => $phoneCode,
        ]);

        $data = $response->toArray();

        return $data['phone_info']['phoneNumber'];
    }

    /**
     * 保存微信登录的头像
     */
    protected function storeAvatar(): string
    {
        // TODO: Implement auth() method.
        return request()->file('avatar')->store('avatars', 'uploads');
    }
}
