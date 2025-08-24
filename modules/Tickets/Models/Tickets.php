<?php

declare(strict_types=1);

namespace Modules\Tickets\Models;

use Catch\Traits\DB\BaseOperate;
use Catch\Traits\DB\DateformatTrait;
use Catch\Traits\DB\ScopeTrait;
use Catch\Traits\DB\Trans;
use Catch\Traits\DB\WithAttributes;
use Modules\Permissions\Models\Traits\DataRange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $ticket_no 工单编号
 * @property string $ticket_name 工单标题
 * @property int $ticket_status 工单状态 (1:待处理, 2:处理中, 3:已完成, 4:已关闭)
 * @property int $ticket_priority 优先级 (1:低, 2:中, 3:高)
 * @property int $ticket_promoter 工单发起人
 * @property int|null $ticket_accept_at 工单受理日期
 * @property int $ticket_accept_overdue 工单受理超期 (0:未超期, 1:超期)
 * @property int $ticket_accept_days 工单受理天数
 * @property int|null $ticket_process_at 工单流程日期
 * @property int $ticket_process_overdue 工单流程超期 (0:未超期, 1:超期)
 * @property int $ticket_process_days 工单处理天数
 * @property int $ticket_node_id 工单节点
 * @property int $ticket_node_accept 工单受理人
 * @property string|null $ticket_node_process 工单流程人
 * @property int $ticket_process_position 工单流程人当前位置
 * @property int $ticket_template 工单模板
 * @property string $ticket_data 工单数据
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $closed_at 关闭时间
 */
class Tickets extends Model
{
    use BaseOperate;
    use DateformatTrait;
    use ScopeTrait;
    use Trans;
    use WithAttributes;
    use DataRange;

    /** 表名 */
    protected $table = 'tickets';

    /** 时间格式 */
    protected $dateFormat = 'U';

    /** 自动填入时间戳 */
    public $timestamps = true;

    /** 允许填充字段 */
    protected $fillable = [
        'id',
        'ticket_no',
        'ticket_name',
        'ticket_status',
        'ticket_priority',
        'ticket_promoter',
        'ticket_accept_at',
        'ticket_accept_overdue',
        'ticket_accept_days',
        'ticket_process_at',
        'ticket_process_overdue',
        'ticket_process_days',
        'ticket_node_id',
        'ticket_node_accept',
        'ticket_node_process',
        'ticket_process_position',
        'ticket_template',
        'ticket_data',
        'created_at',
        'updated_at',
        'closed_at',
    ];

    /** casts */
    protected $casts = [];

    /** 列表显示字段 */
    protected array $fields = [
        'id',
        'ticket_no',
        'ticket_name',
        'ticket_status',
        'ticket_priority',
        'ticket_promoter',
        'ticket_accept_at',
        'ticket_accept_overdue',
        'ticket_accept_days',
        'ticket_process_at',
        'ticket_process_overdue',
        'ticket_process_days',
        'ticket_node_id',
        'ticket_node_accept',
        'ticket_node_process',
        'ticket_process_position',
        'ticket_template',
        'ticket_data',
        'created_at',
        'updated_at',
        'closed_at',
    ];

    /** 表单填充字段 */
    protected array $form = [
        'ticket_no',
        'ticket_name',
        'ticket_status',
        'ticket_priority',
        'ticket_promoter',
        'ticket_accept_at',
        'ticket_accept_overdue',
        'ticket_accept_days',
        'ticket_process_at',
        'ticket_process_overdue',
        'ticket_process_days',
        'ticket_node_id',
        'ticket_node_accept',
        'ticket_node_process',
        'ticket_process_position',
        'ticket_template',
        'ticket_data',
        'closed_at',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 重写字段别名方法，支持DataRange trait
     * 因为工单表使用ticket_promoter而不是creator_id作为创建者字段
     */
    public function aliasField(string $field): string
    {
        if ($field === 'creator_id') {
            return 'ticket_promoter';
        }
        
        return $field;
    }

    /**
     * @return HasOne
     */
    public function ticketTemplates(): HasOne
    {
        return $this->hasOne(related: TicketTemplates::class, foreignKey: 'id', localKey: 'ticket_template');
    }

    /**
     * 关联工单配置
     * @return BelongsTo
     */
    public function ticketConfig(): BelongsTo
    {
        return $this->belongsTo(TicketConfigs::class, 'ticket_node_id', 'id');
    }
}
