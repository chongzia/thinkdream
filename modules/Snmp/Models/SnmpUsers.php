<?php

declare(strict_types=1);

namespace Modules\Snmp\Models;

use Catch\Traits\DB\BaseOperate;
use Catch\Traits\DB\DateformatTrait;
use Catch\Traits\DB\ScopeTrait;
use Catch\Traits\DB\Trans;
use Catch\Traits\DB\WithAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Common\Enums\DeviceAuthorize;
use Modules\Common\Enums\DeviceDealStatus;
use Modules\Permissions\Models\Departments;
use Modules\Permissions\Models\Jobs;

/**
 * @property int $id 编号
 * @property string $name 姓名
 * @property string $phone 电话
 * @property int $positions_id 岗位id
 * @property int $department_id 部门id
 * @property string $device_name 设备名称
 * @property string|null $device_ip 设备ip
 * @property string $device_mac 设备mac
 * @property int|null $device_authorize 设备授权
 * @property string $device_apply 设备申请
 * @property string|null $device_deal 设备受理
 * @property int|null $device_deal_status 设备受理状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property mixed $departments
 * @property mixed $jobs
 * @method scopeCatchOrder($query)
 * @method scopeCatchSearch($query)
 */
class SnmpUsers extends Model
{
    use BaseOperate;
    use DateformatTrait;
    use ScopeTrait;
    use Trans;
    use WithAttributes;

    /** 表名 */
    protected $table = 'snmp_users';

    /** 时间格式 */
    protected $dateFormat = 'U';

    /** 自动填入时间戳 */
    public $timestamps = true;

    /** 允许填充字段 */
    protected $fillable = [
        'id',
        'name',
        'phone',
        'positions_id',
        'department_id',
        'device_name',
        'device_ip',
        'device_mac',
        'device_authorize',
        'device_apply',
        'device_deal',
        'device_deal_status',
        'created_at',
        'updated_at',
    ];

    /** casts */
    protected $casts = [];

    /** 列表显示字段 */
    protected array $fields = [
        'id',
        'name',
        'phone',
        'positions_id',
        'department_id',
        'device_name',
        'device_ip',
        'device_mac',
        'device_authorize',
        'device_apply',
        'device_deal',
        'device_deal_status',
        'created_at',
        'updated_at',
    ];

    /** 表单填充字段 */
    protected array $form = ['name', 'phone', 'positions_id', 'department_id', 'device_name', 'device_mac', 'device_apply'];

    /**
     * 启动模型
     */
    protected static function boot(): void
    {
        parent::boot();

        // 创建记录时设置默认值
        static::creating(function ($model) {
            // 设置默认设备授权状态为"待授权"
            if (is_null($model->device_authorize)) {
                $model->device_authorize = DeviceAuthorize::WAIT_AUTHORIZE->value();
            }
            // 设置默认设备处理状态为"未开始"
            if (is_null($model->device_deal_status)) {
                $model->device_deal_status = DeviceDealStatus::DEALNOTSTART->value();
            }
        });
    }

    public function __construct()
    {
        parent::__construct();
        $this->searchable = [
            'name' => 'like',
            'phone' => 'like',
            'positions_id' => '=',
            'department_id' => '=',
            'device_name' => 'like',
            'device_ip' => 'like',
            'device_mac' => 'like',
            'device_authorize' => '=',
            'device_deal_status' => '=',
        ];
    }

    /**
     * @return HasOne
     */
    public function departments(): HasOne
    {
        return $this->hasOne(related: Departments::class, foreignKey: 'id', localKey: 'department_id');
    }

    /**
     * @return HasOne
     */
    public function jobs(): HasOne
    {
        return $this->hasOne(related: Jobs::class, foreignKey: 'id', localKey: 'positions_id');
    }

    /**
     * 重写 getList 方法，添加关联数据
     *
     * @return LengthAwarePaginator
     */
    public function getList(): LengthAwarePaginator
    {
        // 获取查询构建器
        $query = $this->newQuery();

        // 添加关联
        $query->with([
            'departments:id,department_name',
            'jobs:id,job_name',
        ])->select($this->fields);

        // 应用搜索条件和排序
        // 使用 scope 方法调用本地作用域
        $query->when(method_exists($this, 'scopeCatchSearch'), function ($query) {
            return $this->scopeCatchSearch($query);
        });

        $query->when(method_exists($this, 'scopeCatchOrder'), function ($query) {
            return $this->scopeCatchOrder($query);
        });

        // 执行分页查询
        $result = $query->paginate(request()->input('limit', 10));

        // 手动添加计算属性
        $result->getCollection()->transform(function ($item) {
            $item->position_name = $item->position_name;
            $item->department_name = $item->department_name;
            $item->device_authorize_name = $item->device_authorize_name;
            $item->device_deal_status_name = $item->device_deal_status_name;

            return $item;
        });

        return $result;
    }

    /**
     * 获取岗位名称
     *
     * @return string|null
     */
    public function getPositionNameAttribute(): ?string
    {
        if (is_null($this->positions_id)) {
            return null;
        }
        return $this->jobs?->job_name;
    }

    /**
     * 获取部门名称
     *
     * @return string|null
     */
    public function getDepartmentNameAttribute(): ?string
    {
        if (is_null($this->department_id)) {
            return null;
        }
        
        // 获取部门全路径
        return $this->getDepartmentFullPath($this->department_id);
    }
    
    /**
     * 获取部门全路径
     *
     * @param int $departmentId
     * @return string|null
     */
    protected function getDepartmentFullPath(int $departmentId): ?string
    {
        // 获取当前部门
        $department = app(Departments::class)->find($departmentId);
        
        if (!$department) {
            return null;
        }
        
        // 部门路径数组
        $pathNames = [];
        $pathNames[] = $department->department_name;
        
        // 递归获取上级部门
        $parentId = $department->parent_id;
        while ($parentId > 0) {
            $parent = app(Departments::class)->find($parentId);
            if (!$parent) {
                break;
            }
            
            // 将上级部门名称添加到路径前面
            array_unshift($pathNames, $parent->department_name);
            $parentId = $parent->parent_id;
        }
        
        // 使用 / 连接部门路径
        return implode(' / ', $pathNames);
    }

    /**
     * 获取设备授权状态名称
     *
     * @return string|null
     */
    public function getDeviceAuthorizeNameAttribute(): ?string
    {
        if (is_null($this->device_authorize)) {
            return null;
        }
        
        $deviceAuthorize = DeviceAuthorize::tryFrom((int)$this->device_authorize);
        return $deviceAuthorize?->name();
    }

    /**
     * 获取设备处理状态名称
     *
     * @return string|null
     */
    public function getDeviceDealStatusNameAttribute(): ?string
    {
        if (is_null($this->device_deal_status)) {
            return null;
        }
        
        $deviceDealStatus = DeviceDealStatus::tryFrom((int)$this->device_deal_status);
        return $deviceDealStatus?->name();
    }
}
