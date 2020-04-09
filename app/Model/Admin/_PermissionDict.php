<?php

declare (strict_types=1);

namespace App\Model\Admin;

use App\Model\Model;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * @property int $id
 * @property int $permission_id
 * @property string $name
 * @property string $code
 * @property string $remark
 * @property int $type
 */
class _PermissionDict extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_permission_dict';
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
    protected $casts = ['id' => 'integer', 'permission_id' => 'integer', 'type' => 'integer'];

    /**
     * @return HasMany
     */
    public function lists(): HasMany
    {
        return $this->hasMany(_PermissionDictList::class, 'dict_id', 'id');
    }
}