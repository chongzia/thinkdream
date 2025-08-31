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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\AdminUsers;

/**
 * @property int $id
 * @property int $ticket_id 工单ID
 * @property int $ticket_accept_status 受理状态
 * @property string $ticket_content 回复内容
 * @property int $ticket_user_id 回复人ID
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class TicketReplies extends Model
{
    use BaseOperate;
    use DateformatTrait;
    use ScopeTrait;
    use Trans;
    use WithAttributes;
    use DataRange;

    /** 表名 */
    protected $table = 'ticket_replies';

    /** 时间格式 */
    protected $dateFormat = 'U';

    /** 自动填入时间戳 */
    public $timestamps = true;

    /** 允许填充字段 */
    protected $fillable = [
        'id',
        'ticket_id',
        'ticket_accept_status',
        'ticket_content',
        'ticket_user_id',
        'created_at',
        'updated_at',
    ];

    /** casts */
    protected $casts = [];

    /** 列表显示字段 */
    protected array $fields = [
        'id',
        'ticket_id',
        'ticket_accept_status',
        'ticket_content',
        'ticket_user_id',
        'created_at',
        'updated_at',
    ];

    /** 表单填充字段 */
    protected array $form = [
        'ticket_id',
        'ticket_accept_status',
        'ticket_content',
        'ticket_user_id',
    ];

    public function __construct()
    {
        parent::__construct();
        
        $this->searchable = [
            'ticket_id' => '=',
            'ticket_accept_status' => '=',
            'ticket_user_id' => '=',
            'ticket_content' => 'like',
        ];
    }

    /**
     * 关联到工单
     * @return BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Tickets::class, 'ticket_id', 'id');
    }

    /**
     * 关联到回复人
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(AdminUsers::class, 'ticket_user_id', 'id');
    }
}