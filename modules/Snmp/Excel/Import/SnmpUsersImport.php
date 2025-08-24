<?php

declare(strict_types=1);

namespace Modules\Snmp\Excel\Import;

use Catch\Support\Excel\Import;
use Illuminate\Support\Collection;
use Modules\Snmp\Models\SnmpUsers;

/**
 * 导入数据
 *
 *
 * @class Excel\Import\SnmpUsersImport
 */
class SnmpUsersImport extends Import
{
    /**
     * 导入数据
     *
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows): void
    {
        $rows->each(function ($row) {
        $model = new SnmpUsers;
        $model->name = $row[0];
        $model->phone = $row[1];
        $model->positions_id = $row[2];
        $model->department_id = $row[3];
        $model->device_name = $row[4];
        $model->device_ip = $row[5];
        $model->device_mac = $row[6];
        $model->device_apply = $row[7];
        $model->save();
        });
    }
}
