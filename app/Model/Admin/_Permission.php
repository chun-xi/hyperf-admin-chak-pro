<?php

declare (strict_types=1);

namespace App\Model\Admin;

use App\Model\Model;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * @property int $id
 * @property string $path
 * @property int $pid
 * @property string $name
 * @property int $status
 * @property string $face
 * @property int $type
 * @property int $rank
 */
class _Permission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_permission';
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
    protected $casts = ['id' => 'integer', 'pid' => 'integer', 'status' => 'integer', 'type' => 'integer', 'rank' => 'integer'];

    /**
     * @return HasMany
     */
    public function dicts(): HasMany
    {
        return $this->hasMany(_PermissionDict::class, 'permission_id', 'id');
    }
}