<?php

declare(strict_types=1);

namespace Modules\Snmp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * 验证表单
 * @class SnmpUsersRequest
 */
class SnmpUsersRequest extends FormRequest
{
    /** 验证错误立即停止 */
    protected $stopOnFirstFailure = true;

    /**
     * 验证规则
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|regex:/^[\x{4e00}-\x{9fa5}\.·]{2,32}$/u',
            'phone' => 'required|regex:/^1[3-9]\d{9}$/',
            'positions_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'device_name' => 'required|string',
            'device_ip' => 'ipv4',
            'device_mac' => ['required', 'mac_address'],
        ];
        
        // 添加MAC地址唯一性验证，更新时排除当前记录
        if ($this->route('snmp_user')) {
            $rules['device_mac'][] = Rule::unique('snmp_users', 'device_mac')->ignore($this->route('snmp_user'));
        } else {
            $rules['device_mac'][] = 'unique:snmp_users,device_mac';
        }
        
        return $rules;
    }

    /**
     * 验证规则信息
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => '姓名必填',
            'name.string' => '姓名必须是字符串',
            'name.regex' => '姓名长度必须是2到32个字符(仅允许中文、.和·)',
            'phone.required' => '电话必填',
            'phone.regex' => '电话必须是11位的手机号码',
            'positions_id.required' => '岗位id必填',
            'positions_id.exists' => '岗位必须存在',
            'department_id.required' => '部门id必填',
            'department_id.exists' => '部门必须存在',
            'device_name.required' => '设备名称必填',
            'device_name.string' => '设备名称必须是字符串',
            'device_ip.ipv4' => '设备ip必须是有效的IPv4地址',
            'device_mac.required' => '设备mac必填',
            'device_mac.mac_address' => '设备mac必须是有效的MAC地址',
            'device_mac.unique' => '该MAC地址已被使用',
        ];
    }
}
