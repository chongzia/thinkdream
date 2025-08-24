<?php
namespace App\Exceptions;

use App\Enums\Code;

class FailedException extends ApiAppException
{
    protected $code = Code::FAILED;
}
