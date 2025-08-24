<?php

namespace Modules\Common\Repository\Options;

use Catch\Enums\Status;
use Modules\System\Models\DictionaryValues;

class TicketPriority implements OptionInterface
{
    public function get(): array
    {
        $dictionary = [];
        
        // 从字典表获取工单优先级数据 (dic_id = 2)
        DictionaryValues::where('status', Status::Enable->value())
            ->where('dic_id', 2)
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