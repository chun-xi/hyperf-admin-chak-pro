<?php

declare (strict_types=1);

namespace App\Model\Admin;

use App\Model\Model;
use Hyperf\Database\Model\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property int $status
 */
class _Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_role';
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
    protected $casts = ['id' => 'integer', 'status' => 'integer'];


    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(_Permission::class, '_role_permission', 'role_id', 'permission_id');
    }
}