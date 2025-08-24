<?php

namespace Modules\Pay\Support;

use Modules\Pay\Support\NotifyData\NotifyData;

interface PayInterface
{
    public function refund(array $params): mixed;

    public function notify(): mixed;
}
