<?php
namespace App\Exceptions;

use App\Enums\Code;

class UnauthorizedAccessException extends ApiAppException
{
    protected $code = Code::LOGIN_FAILED;
}
