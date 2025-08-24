<?php

namespace Modules\Domain\Support\Sign;

use Catch\Exceptions\FailedException;
use Illuminate\Support\Str;

class Aliyun
{
    /**
     * @var array
     */
    protected array $params;

    protected array $data;

    protected string $secretId;

    protected string $secretKey;

    protected string $version = '2015-01-09';

    protected string $host = 'alidns.aliyuncs.com';

    protected string $algorithm = 'ACS3-HMAC-SHA256';

    protected string $canonicalUri = '/';

    protected array $headers;

    protected string $httpMethod;

    /**
     * @param  array  $headers
     * @param  array  $data
     */
    public function __construct(array $headers, array $data)
    {
        $this->data = $data;

        if (! $secretId = config('domain.aliyun.access_key')) {
            throw new FailedException('阿里云域名管理 access_key 未设置');
        }

        if (! $secretKey = config('domain.aliyun.access_secret')) {
            throw new FailedException('阿里云域名管理密钥未设置');
        }

        $this->secretId = $secretId;

        $this->secretKey = $secretKey;

        $this->headers = $headers;

        $this->headers['x-acs-content-sha256'] = $this->getHashedRequestPayload();

    }

    protected function getCanonicalHeaderString(): string
    {
        $signHeaders = $this->getSignHeaders();
        $headers = $this->headers;

        ksort($headers);
        $canonicalHeaderString = '';

        foreach ($headers as $k => $v) {
            if (in_array($k, $signHeaders)) {
                $canonicalHeaderString .= $k.':'.trim($v)."\n";
            }
        }

        if (! $canonicalHeaderString) {
            $canonicalHeaderString = "\n";
        }

        return $canonicalHeaderString;
    }

    protected function getSignHeaders(): array
    {
        $signHeaders = [];
        foreach ($this->headers as $k => $v) {
            $headerKey = Str::of($k)->lower();

            if ($headerKey->startsWith('x-acs-') || $headerKey->exactly('host') || $headerKey->exactly('content-type')) {
                $signHeaders[] = $k;
            }
        }

        sort($signHeaders);

        return $signHeaders;
    }

    protected function getHashedRequestPayload(): string
    {
        return $this->hashEncode('');
    }

    protected function hashEncode(string $data): string
    {
        return bin2hex(hash('sha256', $data, true));
    }

    /**
     * @return string
     */
    protected function getCanonicalQueryString(): string
    {
        $query = $this->data;

        ksort($query);

        return http_build_query($query);
    }

    /**
     * @return string
     */
    protected function createCanonicalRequest(): string
    {
        return $this->httpMethod."\n"
            .$this->canonicalUri."\n"
            .$this->getCanonicalQueryString()."\n"
            .$this->getCanonicalHeaderString()."\n"
            .implode(';', $this->getSignHeaders())."\n"
            .$this->getHashedRequestPayload();
    }

    public function authorization($method): array
    {
        $this->httpMethod = strtoupper($method);

        $signHeaders = $this->getSignHeaders();
        $signHeadersString = implode(';', $signHeaders);

        $canonicalRequest = $this->createCanonicalRequest();

        $strtosign = $this->algorithm."\n".$this->hashEncode($canonicalRequest);

        $signature = hash_hmac('sha256', $strtosign, $this->secretKey, true);

        $signature = bin2hex($signature);

        $this->headers['Authorization'] = $this->algorithm.
            ' Credential='.$this->secretId.
            ',SignedHeaders='.$signHeadersString.
            ',Signature='.$signature;

        return $this->headers;
    }
}
