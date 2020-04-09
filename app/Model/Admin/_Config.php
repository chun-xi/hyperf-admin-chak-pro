<?php

declare (strict_types=1);
namespace App\Model\Admin;

use App\Model\Model;

/**
 * @property int $id 
 * @property int $category_id 
 * @property string $name 
 * @property string $key 
 * @property string $options 
 * @property int $private 
 */
class _Config extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_config';
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
    protected $casts = ['id' => 'integer', 'category_id' => 'integer', 'private' => 'integer'];
}