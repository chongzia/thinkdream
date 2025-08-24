<?php

declare(strict_types=1);

namespace Modules\System\Models;

use Catch\Traits\DB\BaseOperate;
use Catch\Traits\DB\ScopeTrait;
use Catch\Traits\DB\Trans;
use Catch\Traits\DB\WithAttributes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $tokenable_type
 * @property $tokenable_id
 * @property $name
 * @property $token
 * @property $abilities
 * @property $last_used_at
 * @property $expires_at
 * @property $created_at
 * @property $updated_at
 */
class PersonalAccessTokens extends Model
{
    use BaseOperate;
    use ScopeTrait;
    use Trans;
    use WithAttributes;

    protected $table = 'personal_access_tokens';

    protected $fillable = ['id', 'tokenable_type', 'tokenable_id', 'name', 'token', 'abilities', 'last_used_at', 'expires_at', 'created_at', 'updated_at'];

    protected array $fields = ['personal_access_tokens.*'];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i',
        'expires_at' => 'date:Y-m-d H:i',
    ];

    protected function expiresAt(): Attribute
    {
        $expiration = config('sanctum.expiration');

        return new Attribute(
            get: fn () => $expiration ? $this->created_at->addMinutes($expiration)->format('Y-m-d H:i') : null
        );
    }
}
