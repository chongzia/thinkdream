<?php

namespace App\Enums;

/**
 * 枚举项目的返回码
 */
enum Code: int implements Enum
{
    case SUCCESS = 10000;
    case FAILED = 10001;
    case LOGIN_FAILED = 10002;
    case AUTH_EXCEPTION = 10003;
    case TOKEN_EXPIRED = 10004;
    case TOKEN_INVALID = 10005;
    case TOKEN_BLACKLIST = 10006;
    case TOKEN_MISSED = 10007;
    case QUERY_FAILED = 10008;

    public function message(): string
    {
        return match ($this) {
            self::SUCCESS => 'success',
            self::FAILED => 'failed',
            self::LOGIN_FAILED => '登录失败',
            self::AUTH_EXCEPTION => '认证失败',
            self::TOKEN_EXPIRED => 'token 过期',
            self::TOKEN_INVALID => 'token 无效',
            self::TOKEN_BLACKLIST => 'token 黑名单',
            self::TOKEN_MISSED => 'token 丢失',
            self::QUERY_FAILED => '查询失败',
        };
    }

    public function equal(mixed $value): bool
    {
        return $this->value === $value;
    }
}
