<?php

namespace Modules\Common\Repository\Options;

use Catch\Enums\Status;
use Modules\System\Models\DictionaryValues;

class TicketStatus implements OptionInterface
{
    public function get(): array
    {
        $dictionary = [];
        
        // 从字典表获取工单状态数据 (dic_id = 3)
        DictionaryValues::where('status', Status::Enable->value())
            ->where('dic_id', 3)
            ->where('deleted_at', 0)
            ->orderBy('sort')
            ->orderBy('value')
            ->get()
            ->each(function ($item) use (&$dictionary) {
                $dictionary[] = [
                    'label' => $item->label,
                    'value' => $item->value,
                ];
            });

        return $dictionary;
    }
}
