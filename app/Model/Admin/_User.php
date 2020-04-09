<?php

declare (strict_types=1);

namespace App\Model\Admin;

use App\Model\Model;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $user
 * @property string $pass
 * @property string $face
 * @property string $salt
 * @property string $address
 * @property int $status
 * @property string $remark
 * @property string $s_pass
 * @property string $secret
 * @property int $secret_status
 * @property string $login_date
 * @property string $create_date
 */
class _User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'secret_status' => 'integer'];


    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(_Role::class, '_user_role', 'user_id', 'role_id');
    }
}