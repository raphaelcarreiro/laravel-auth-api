<?php

namespace Core\User\Infra\DB\Eloquent\Models;

use DateTime;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class UserModel extends Authenticatable
{
    public $incrementing = false;
    public $keyType = 'string';

    public $table = 'users';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
