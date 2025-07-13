<?php

namespace Core\Auth\Infra\DB\Eloquent\Models;

use Core\User\Infra\DB\Eloquent\Models\UserModel;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $user_id
 * @property DateTime $created_at
 * @property int $expires_at
 */
class RefreshTokenModel extends Model
{
    protected $table = 'refresh_tokens';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    public $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'created_at',
        'expires_at',
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'created_at' => 'datetime',
        'expires_at' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }
}
