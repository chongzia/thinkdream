<?php
namespace App\Exceptions;

use App\Enums\Code;

class AuthenticationException extends ApiAppException
{
    protected $code = Code::AUTH_EXCEPTION;
}
