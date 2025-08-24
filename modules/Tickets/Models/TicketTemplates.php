<?php

declare(strict_types=1);

namespace Modules\Tickets\Models;

use Catch\Traits\DB\BaseOperate;
use Catch\Traits\DB\DateformatTrait;
use Catch\Traits\DB\ScopeTrait;
use Catch\Traits\DB\Trans;
use Catch\Traits\DB\WithAttributes;
use Modules\Permissions\Models\Traits\DataRange;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $ticket_name 模板名称
 * @property string|null $ticket_description 模板描述
 * @property string|null $ticket_form 模板表单
 * @property int $ticket_accept 模板受理人
 * @property string $ticket_process 模板流程人
 * @property int $ticket_accept_days 模板受理天数
 * @property int $ticket_process_days 模板处理天数
 * @property int $ticket_is_active 模板启用
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class TicketTemplates extends Model
{
    use DateformatTrait;
    use BaseOperate;
    use ScopeTrait;
    use Trans;
    use WithAttributes;
    use DataRange;

    /** 表名 */
    protected $table = 'ticket_templates';

    /** 时间格式 */
    protected $dateFormat = 'U';

    /** 自动填入时间戳 */
    public $timestamps = true;

    /** 允许填充字段 */
    protected $fillable = ['id', 'ticket_name', 'ticket_description', 'ticket_form', 'ticket_accept', 'ticket_process', 'ticket_accept_days', 'ticket_process_days', 'ticket_is_active', 'created_at', 'updated_at'];

    /** casts */
    protected $casts = [];

    /** 列表显示字段 */
    protected array $fields = ['id', 'ticket_name', 'ticket_description', 'ticket_form', 'ticket_accept', 'ticket_process', 'ticket_accept_days', 'ticket_process_days', 'ticket_is_active', 'created_at', 'updated_at'];

    /** 表单填充字段 */
    protected array $form = ['ticket_name', 'ticket_description', 'ticket_form', 'ticket_accept', 'ticket_process', 'ticket_accept_days', 'ticket_process_days', 'ticket_is_active'];

    public function __construct()
    {
        parent::__construct();
        
        // 设置可搜索字段 - 参考 SnmpUsers 模型的成功实现
        $this->searchable = [
            'ticket_name' => 'like',
            'ticket_is_active' => '=',
            'ticket_accept' => '=',
            'ticket_process' => 'like',
        ];
    }

    /**
     * @return HasOne
     */
    public function tickets(): HasOne
    {
        return $this->hasOne(related: Tickets::class, foreignKey: 'template_id', localKey: 'id');
    }

    /**
     * 关联工单配置（一个模板可以有多个配置）
     * @return HasMany
     */
    public function ticketConfigs(): HasMany
    {
        return $this->hasMany(TicketConfigs::class, 'template_id', 'id');
    }
}
