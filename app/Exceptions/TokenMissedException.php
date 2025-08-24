<?php
namespace App\Exceptions;

use App\Enums\Code;

class TokenMissedException extends ApiAppException
{
    protected $code = Code::TOKEN_MISSED;
}
