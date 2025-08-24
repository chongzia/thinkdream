<?php
namespace Modules\Shop\Models;

use Catch\Traits\DB\BaseOperate;
use Catch\Traits\DB\ScopeTrait;
use Catch\Traits\DB\Trans;
use Catch\Traits\DB\WithAttributes;
use Illuminate\Database\Eloquent\Model;

class UserPointsLog extends Model
{
    use BaseOperate;
    use ScopeTrait;
    use Trans;
    use WithAttributes;

    protected $table = 'shop_user_points_log';

    protected $fillable = [
        'user_id',
        'point_num',
        'type',
        'description',
        'remark',
    ];

    protected $dateFormat = 'U';
}
