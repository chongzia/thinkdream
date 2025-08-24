<?php

namespace Modules\Shop\Services;

use Modules\Shop\Services\Logistics\LogisticFactory;

class LogisticService
{
    public function search(string $orderNo)
    {
        return app(LogisticFactory::make(LogisticFactory::GLOBAL_LOGISTIC))->traces([
            'order_no' => $orderNo,
        ]);
    }


    public function expressLists()
    {
        return app(LogisticFactory::make(LogisticFactory::GLOBAL_LOGISTIC))->expressLists();
    }

}
