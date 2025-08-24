<?php

namespace Modules\Common\Repository\Options;

use Modules\Common\Enums\TicketTemplatesStatus as TicketTemplatesStatusEnum;

class TicketTemplatesStatus implements OptionInterface
{
    public function get(): array
    {
        return [
            [
                'label' => TicketTemplatesStatusEnum::ENABLE->name(),
                'value' => TicketTemplatesStatusEnum::ENABLE->value(),
            ],
            [
                'label' => TicketTemplatesStatusEnum::DISABLE->name(),
                'value' => TicketTemplatesStatusEnum::DISABLE->value(),
            ],
        ];
    }
}