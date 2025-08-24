<?php

declare(strict_types=1);

namespace Modules\Snmp\Excel\Export;

use Catch\Support\Excel\Export;
use Illuminate\Support\Collection;
use Modules\Snmp\Models\SnmpUsers;

/**
 * 导出数据
 *
 *
 * @class Excel\Export\SnmpUsersExport
 */
class SnmpUsersExport extends Export
{
    protected array $header = [
        '编号',
        '姓名',
        '电话',
        '岗位',
        '部门',
        '设备名称',
        '设备ip',
        '设备mac',
        '设备授权状态',
        '设备申请',
        '设备受理',
        '设备受理状态',
        '创建时间',
        '更新时间',
    ];

    /**
     * @return array
     */
    public function array(): array
    {
        // 先获取模型实例，加载关联关系，应用获取器
        $models = SnmpUsers::query()
            ->with(['departments:id,department_name', 'jobs:id,job_name'])
            ->get();
        
        // 然后只保留需要的字段，使用获取器获取名称而不是ID
        return $models->map(function ($model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'phone' => $model->phone,
                'positions_id' => $model->position_name, // 使用获取器
                'department_id' => $model->department_name, // 使用获取器
                'device_name' => $model->device_name,
                'device_ip' => $model->device_ip,
                'device_mac' => $model->device_mac,
                'device_authorize' => $model->device_authorize_name, // 使用获取器
                'device_apply' => $model->device_apply,
                'device_deal' => $model->device_deal,
                'device_deal_status' => $model->device_deal_status_name, // 使用获取器
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ];
        })->toArray();
    }
}
