<?php

declare(strict_types=1);

namespace Modules\Ai\Models;

use Catch\Base\CatchModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id
 * @property $provider_id
 * @property $name
 * @property $display_name
 * @property $max_token
 * @property $is_support_image
 * @property $creator_id
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class AiModels extends Model
{
    /** 表名 */
    protected $table = 'ai_provider_models';

    /** 允许填充字段 */
    protected $fillable = [
        'id',
        'name',
        'provider_id',
        'display_name',
        'max_token',
        'is_support_image',
        'status',
        'creator_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** 列表显示字段 */
    protected array $fields = ['id', 'provider_id', 'name', 'display_name', 'max_token', 'is_support_image', 'created_at', 'updated_at'];

    /** 表单填充字段 */
    protected array $form = ['name', 'provider_id', 'display_name', 'max_token', 'is_support_image'];

    public static function findModel(string $model): ?AiModels
    {
        return self::query()->where('name', $model)->first();
    }

    /**
     * 智能体
     *
     * @return BelongsToMany
     */
    public function robots()
    {
        return $this->belongsToMany(ChatBots::class, 'ai_robot_models', 'model_id', 'robot_id');
    }
}
