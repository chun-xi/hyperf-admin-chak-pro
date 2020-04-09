<?php

declare (strict_types=1);
namespace App\Model\Admin;

use App\Model\Model;

/**
 * @property int $id 
 * @property int $role_id 
 * @property int $permission_id 
 */
class _RolePermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_role_permission';
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
    protected $casts = ['id' => 'integer', 'role_id' => 'integer', 'permission_id' => 'integer'];
}