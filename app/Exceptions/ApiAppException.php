<?php

namespace App\Exceptions;

use App\Enums\Code;
use App\Enums\Enum;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @class ApiException
 */
abstract class ApiAppException extends HttpException
{
    //
    public function __construct(
        string $message = '',
        Code $code = Code::FAILED
    ) {
        if ($this->code instanceof Enum) {
            $code = $this->code;

            $this->message = $this->code->message();
        }

        parent::__construct(
            $this->statusCode(),
            $message ?: $this->message,
            null,
            [],
            $code->value
        );
    }

    /**
     * @return int
     */
    protected function statusCode(): int
    {
        return 500;
    }
}
